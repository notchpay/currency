<?php

namespace ForexAPI\Currency\Console;

use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Hydrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:hydrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get currencies or Update rates';

    /**
     * Currency storage instance
     *
     * @var \ForexAPI\Currency\Contracts\DriverInterface
     */
    protected $storage;

    /**
     * All installable currencies.
     *
     * @var array
     */
    protected $currencies;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        $this->storage = app('currency')->getDriver();

        parent::__construct();
    }

    /**
     * Execute the console command for Laravel 5.4 and below
     *
     * @return void
     */
    public function fire()
    {
        $this->handle();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {

        //get rates form forexapi
        $r = Http::withHeaders([
            'X-API-Key' => config('currency.api_key'),
        ])->get('https://api.forexapi.world/rates');



        if ($r->successful()) {

            switch (config('currency.driver')) {
                case 'model':
                    $model = config('currency.drivers.model.class');
                    $this->currencies = $model::all();

                    if (count($this->currencies) == 0) {
                        foreach ($r->json() as $rate) {
                            $model::create(Arr::only($rate, ['name', 'code', 'symbol', 'exchange_rate', 'fraction']));
                        }
                    } else {

                        foreach ($r->json() as $rate) {
                            $currency = $this->currencies->where("code", $rate['code'])->first();
                            $currency->update(Arr::only($rate, ['exchange_rate',]));
                        }
                    }

                    break;

                case 'database':
                    $table = config('currency.drivers.database.table');
                    $this->currencies = DB::table($table)->get();

                    if (count($this->currencies) == 0) {
                        foreach ($r->json() as $rate) {
                            DB::table($table)->insert(Arr::only($rate, ['name', 'code', 'symbol', 'exchange_rate', 'fraction']));
                        }
                    } else {

                        foreach ($r->json() as $rate) {
                            $currency = $this->currencies->where("code", $rate['code'])->first();
                            $currency->update(Arr::only($rate, ['exchange_rate',]));
                        }
                    }

                    break;

                default:
                    # code...
                    break;
            }


            $this->info("Rates hydrated from forexapi");
        } else {

            $this->error("Failed to fetch rates from forexapi");
        }
    }
}

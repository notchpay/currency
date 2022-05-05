<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Currency
    |--------------------------------------------------------------------------
    |
    | The application currency determines the default currency that will be
    | used by the currency service provider. You are free to set this value
    | to any of the currencies which will be supported by the application.
    |
    */

    'default' => 'USD',

    /*
    |--------------------------------------------------------------------------
    | API Key for FOREXAPI
    |--------------------------------------------------------------------------
    |
    | Only required if you with to use the Open Exchange Rates api. You can
    | always just use Yahoo, the current default.
    |
    */

    'api_key' => env(
        "RESTUNIVERE_API_KEY",
    ),

    /*
    |--------------------------------------------------------------------------
    | Default Storage Driver
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default storage driver that should be used
    | by the framework.
    |
    | Supported: "database", "filesystem", "Model"
    |
    */

    'driver' => 'model',

    /*
    |--------------------------------------------------------------------------
    | Default Storage Driver
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default cache driver that should be used
    | by the framework.
    |
    | Supported: all cache drivers supported by Laravel
    |
    */

    'cache_driver' => null,

    /*
    |--------------------------------------------------------------------------
    | Storage Specific Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many storage drivers as you wish.
    |
    */

    'drivers' => [

        'database' => [
            'class' => \RestUniverse\Currency\Drivers\Database::class,
            'connection' => null,
            'table' => 'currencies',
        ],

        'filesystem' => [
            'class' => \RestUniverse\Currency\Drivers\Filesystem::class,
            'disk' => null,
            'path' => 'currencies.json',
        ],

        'model' => [
            'table' => 'currencies',
            'class' => App\Models\Currency::class
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Currency Formatter
    |--------------------------------------------------------------------------
    |
    | Here you may configure a custom formatting of currencies. The reason for
    | this is to help further internationalize the formatting past the basic
    | format column in the table. When set to `null` the package will use the
    | format from storage.
    |
    |
    */

    'formatter' => null,

    /*
    |--------------------------------------------------------------------------
    | Currency Formatter Specific Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many currency formatters as you wish.
    |
    */

    'formatters' => [

        'php_intl' => [
            'class' => \RestUniverse\Currency\Formatters\PHPIntl::class,
        ],

    ],
];

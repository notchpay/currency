# Rest Universe Currency


## Installation

- [Currency on Packagist](https://packagist.org/packages/notchpay/currency)
- [Currency on GitHub](https://github.com/notchpay/currency)

### Composer

From the command line run:

```bash
$ composer require restuniverse/currency
```

### Laravel's >=5.5 Auto-Discovery

Simply install the package and let Laravel do its magic.

### Manual Setup

Once installed you need to register the service provider with the application. Open up `config/app.php` and find the `providers` key.

```php
'providers' => [

    \RestUniverse\Currency\CurrencyServiceProvider::class,

]
```

This package also comes with a facade, which provides an easy way to call the the class. Open up `config/app.php` and find the `aliases` key.

```php
'aliases' => [

    'Currency' => \RestUniverse\Currency\Facades\Currency::class,

];
```

### Publish the configurations

Run this on the command line from the root of your project:

```bash
php artisan vendor:publish --provider="RestUniverse\Currency\CurrencyServiceProvider" --tag=config
```

A configuration file will be published to `config/currency.php`.

### Migration

If currencies are going to be stored in the database. 

```bash
php artisan vendor:publish --provider="RestUniverse\Currency\CurrencyServiceProvider" --tag=migrations
```

Run this on the command line from the root of your project to generate the table for storing currencies:

```bash
$ php artisan migrate
```

> note: Add your API_KEY to the .env file with (REST_UNIVERSE_API_KEY).

## Basic usage


The simplest way to use these methods is through the helper function `currency()` or by using the facade. For the examples below we will use the helper method.

```php
currency($amount, $from = null, $to = null, $format = true)
```



**Arguments:**

`$amount` - The float amount to convert
`$from` - The current currency code of the amount. If not set, the application default will be used (see `config/currency.php` file).
`$to` - The currency code to convert the amount to. If not set, the user-set currency is used.
`$format` - Should the returned value be formatted.

**Usage:**

```php
echo currency(12.00);               // Will format the amount using the user selected currency
echo currency(12.00, 'USD', 'EUR'); // Will format the amount from the default currency to EUR
```

### Updating Exchange Rates

Update exchange rates from restuniverse.com. An API key is needed to use [Rest Universe](http://restuniverse.com). Add yours to the config file.

```bash
php artisan currency:hydrate
```

## Security

If you discover any security related issues, please email security@restuniverse.com instead of using the issue tracker.


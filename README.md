# Azampay in PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/alphaolomi/azampay-php.svg?style=flat-square)](https://packagist.org/packages/alphaolomi/azampay-php)
[![Tests](https://github.com/alphaolomi/azampay-php/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/alphaolomi/azampay-php/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/alphaolomi/azampay-php.svg?style=flat-square)](https://packagist.org/packages/alphaolomi/azampay-php)

This is where your description should go. Try and limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require alphaolomi/azampay-php
```

## Usage

```php
use Alphaolomi\Azampay;

$azampayService = new Azampay([
    "appName" => "ABC Shop",
    "clientId" => "YOUR_CLIENT_ID",
    "clientSecret" => "A_VERY_LONG_STRING",
    "environment" => "sandbox", // or live
]);

$result =  $azampayService->mobileCheckout([
    "accountNumber" =>  "255747123123",   
    "amount" =>  "40000",
    "currency" =>  "TZS",
    "externalId" =>  "123", // optional
    "provider" =>  "Airtel",
    "additionalProperties" =>  [
        "description" =>  "Dozen of Azam Apple Punch",
    ],
]);

print_r($result);
```


## Available methods

### `generateToken()`
### `mobileCheckout(array $data)`
### `bankCheckout(array $data)`


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Alpha Olomi](https://github.com/alphaolomi)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

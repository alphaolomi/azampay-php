# Azampay for PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/alphaolomi/azampay-php.svg?style=flat-square)](https://packagist.org/packages/alphaolomi/azampay-php)
[![Tests](https://img.shields.io/github/actions/workflow/status/alphaolomi/azampay-php/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/alphaolomi/azampay-php/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/alphaolomi/azampay-php.svg?style=flat-square)](https://packagist.org/packages/alphaolomi/azampay-php)

Azampay for PHP is a PHP client for [Azampay](https://azampay.com/) (Innovating Digital Commerce Infrastructure in Africa).

## Installation

You can install the package via composer:

```bash
composer require alphaolomi/azampay-php
```

## Usage

```php
use AlphaOlomi\AzampayService;

$azampay = new AzampayService([]);
// Or
$azampay = AzampayService::create([]);


// The following methods are available

// Get MNOs Available (Mobile Network Operators)
$mnoRes =  $azampay->getMNOs();


// MNO Checkout
$mnoCheckoutRes =  $azampay->mnoCheckout([]);

// Bank Checkout
$bankCheckoutRes =  $azampay->bankCheckout([]);
```

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

- [Alpha Olomi](https://github.com/alphaolomi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

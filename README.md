# Implementing Brick Money on Laravel Livewire and Wiretables can be achieved gracefully by following some best practices

[![Latest Version on Packagist](https://img.shields.io/packagist/v/xitedev/wiretables-money.svg?style=flat-square)](https://packagist.org/packages/xitedev/wiretables-money)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/xitedev/wiretables-money/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/xitedev/wiretables-money/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/xitedev/wiretables-money/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/xitedev/wiretables-money/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/xitedev/wiretables-money.svg?style=flat-square)](https://packagist.org/packages/xitedev/wiretables-money)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/wiretables-money.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/wiretables-money)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require xitedev/wiretables-money
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="wiretables-money-views"
```

## Usage

### Wiretables column

```php
use Xite\WiretablesMoney\Columns\MoneyColumn;

return collect([
    MoneyColumn::make('amount')
        ->showSign()
        ->displayIf(fn ($row) => $row->amount->isPositive()),
]);
```

### Wireforms field

```php
use Xite\WiretablesMoney\Fields\MoneyField;
use Xite\WiretablesMoney\Rules\MoneyRule;
use Xite\WiretablesMoney\Rules\MoneyNotZeroRule;

return collect([
    MoneyField::make('amount', __('fields.amount'))
        ->required()
        ->rules([
             new MoneyRule(0, 100),
             new MoneyNotZeroRule()
        ])
]);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.


## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Xite](https://github.com/xitedev)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

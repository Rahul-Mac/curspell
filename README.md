<p align="center"><a href="https://packagist.org/packages/rahulmac/curspell" target="_blank"><img src="https://raw.githubusercontent.com/Rahul-Mac/curspell/refs/heads/main/assets/curspell.png" width="400" alt="Curspell Logo"></a></p>

<p align="center">
<a href="https://packagist.org/packages/rahulmac/curspell" target="_blank"><img alt="Packagist Version" src="https://img.shields.io/packagist/v/rahulmac/curspell"></a>
<a href="https://github.com/Rahul-Mac/curspell/blob/main/LICENSE" target="_blank"><img alt="GitHub License" src="https://img.shields.io/github/license/Rahul-Mac/curspell"></a></p>


# Curspell

Curspell (short for currency speller) is a PHP package to spell out currency amounts.

# Installation

```bash
composer require rahulmac/curspell
```

# Prerequisites

- PHP v8.0+
- The `intl` extension

# Usage

## Basic Usage

Simply create an object and invoke `spell()` with the amount.

> By default, it uses `USD` as the currency code and `en_US` as the locale.

```php
use Rahulmac\Curspell\Curspell;

echo (new Curspell())->spell(123.45);    // one hundred twenty-three dollars and forty-five cents
```

## Currency Code and Locale

You can change the currency code and locale of your choice.

> [!NOTE]  
> For now, the package can only spellout amounts in the English language.

```php
use Rahulmac\Curspell\Curspell;

echo (new Curspell())->setCode('INR')->setLocale('en_IN')->spell(123.45);    // one hundred twenty-three rupees and forty-five paise
```

## Helper Function

You may choose to use a helper function instead of the object.

```php
use function Rahulmac\Curspell\Support\curspell;

curspell(12.34, 'GBP', 'en_GB');    // twelve pounds and thirty-four pence
```

# Supported Currencies

Here is the list of the [currencies](/docs/CURRENCY_LOCALE.md) this package supports.

# License

Curspell is open-sourced software licensed under the [MIT license](LICENSE).
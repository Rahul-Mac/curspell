![Curspell](/assets/curspell.png)

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

echo (new Curspell())->spell(123.456);    // one hundred twenty-three dollars and four hundred fifty-six cents
```

## Currency Code and Locale

You can change the currency code and locale of your choice.

> [!NOTE]  
> For now, the package can only spellout amounts in the English language.

```php
use Rahulmac\Curspell\Curspell;

echo (new Curspell())->setCode('INR')->setLocale('en_IN')->spell(123.456);    // one hundred twenty-three rupees and four hundred fifty-six paise
```

# Supported Currencies

Here is the list of the [currencies](/docs/CURRENCY_LOCALE.md) this package supports.

# License

Curspell is open-sourced software licensed under the [MIT license](LICENSE).
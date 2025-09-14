<?php

namespace Rahulmac\Curspell\Config;

use Rahulmac\Curspell\Exceptions\UnknownCurrencyCodeException;
use Rahulmac\Curspell\Exceptions\UnknownLocaleException;

final class Configuration
{
    private array $currency = [];

    /**
     * @throws UnknownCurrencyCodeException If the given code if not supported or is invalid.
     * @throws UnknownLocaleException       If the given locale if not supported or is invalid.
     */
    public function __construct(string $code, private string $locale)
    {
        $file = __DIR__ . "/$code.php";

        if (! \file_exists($file)) {
            throw new UnknownCurrencyCodeException("The following currency code is not supported or is invalid: $code");
        }

        $this->currency = require $file;

        if (! \key_exists($locale, $this->currency)) {
            throw new UnknownLocaleException("The following locale is not supported or is invalid: $locale");
        }
    }

    public function getBase(int $amount): string
    {
        return $this->getUnit($amount, 'base');
    }

    public function getFraction(int $amount): string
    {
        return $this->getUnit($amount, 'fraction');
    }

    public function getUnit(int $amount, string $unit): string
    {
        $grammaticalNumber = $amount === 1 ? 'singular' : 'plural';

        return $this->currency[$this->locale][$unit][$grammaticalNumber];
    }

    public function getConjunction(): string
    {
        return $this->currency[$this->locale]['conjunction'];
    }

    public function getSubunit(): int
    {
        return \key_exists('subunit', $this->currency) ? $this->currency['subunit'] : 100;
    }
}

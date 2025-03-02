<?php

namespace Rahulmac\Curspell\Config;

use Rahulmac\Curspell\Exceptions\UnknownLocaleException;
use Rahulmac\Curspell\Exceptions\UnknownCurrencyCodeException;

/**
 * Configuration
 * 
 * @author Rahul Mac <rahulmacwan14@gmail.com>
 * 
 * @copyright (c) 2025
 * 
 * @license https://opensource.org/licenses/MIT MIT License
 */
final class Configuration
{
    /**
     * Map of currency and the associated base and fraction units
     */
    private array $currency = [];

    /**
     * Create a new instance of Configuration
     * 
     * @throws UnknownCurrencyCodeException If the given code if not supported or is invalid
     * @throws UnknownLocaleException If the given locale if not supported or is invalid
     */
    public function __construct(string $code, private string $locale)
    {
        $file = __DIR__ . "\\$code.php";

        if (! file_exists($file)) {
            throw new UnknownCurrencyCodeException("The following currency code is not supported or is invalid: {$code}");
        }

        $this->currency = require $file;

        if (! key_exists($locale, $this->currency)) {
            throw new UnknownLocaleException("The following locale is not supported or is invalid: {$locale}");
        }
    }

    /**
     * Return the base based on the amount
     */
    public function getBase(int $amount): string
    {
        return $this->getUnit($amount, 'base');
    }

    /**
     * Return the fraction based on the amount
     */
    public function getFraction(int $amount): string
    {
        return $this->getUnit($amount, 'fraction');
    }

    /**
     * Return the unit value
     */
    public function getUnit(int $amount, string $unit): string
    {
        $grammaticalNumber = $amount === 1 ? 'singular' : 'plural';

        return $this->currency[$this->locale][$unit][$grammaticalNumber];
    }

    /**
     * Return the conjunction for the base and fraction
     */
    public function getConjunction(): string
    {
        return $this->currency[$this->locale]['conjunction'];
    }

    public function getSubunit(): int
    {
        return key_exists('subunit', $this->currency) ? $this->currency['subunit'] : 100;
    }
}


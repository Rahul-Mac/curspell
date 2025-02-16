<?php

namespace Rahulmac\Curspell;

use NumberFormatter;
use Rahulmac\Curspell\Config\Configuration;
use Rahulmac\Curspell\Exceptions\UnknownLocaleException;
use Rahulmac\Curspell\Exceptions\UnknownCurrencyCodeException;

/**
 * Currency Speller
 * 
 * @package Curspell
 * 
 * @author Rahul Mac <rahulmacwan14@gmail.com>
 * 
 * @copyright (c) 2025
 * 
 * @license https://opensource.org/licenses/MIT MIT License
 */
final class Curspell
{
    /**
     * The currency code
     */
    private string $code = 'USD';

    /**
     * Locale
     */
    private string $locale = 'en_US';

    /**
     * Set the currency code
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Set the locale
     */
    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Spell the amount
     * 
     * @throws UnknownCurrencyCodeException If the currency code is invalid or unsupported
     * @throws UnknownLocaleException If the locale is invalid or unsupported
     */
    public function spell(mixed $amount): string
    {
        $amount = strval($amount);

        $parts = explode('.', $amount);

        $config = new Configuration($this->code, $this->locale);

        $numberFormatter = new NumberFormatter($this->locale, NumberFormatter::SPELLOUT);
    
        $base = floatval($parts[0]);

        $result = $numberFormatter->format($base) . ' ' . $config->getBase($base);

        if (key_exists(1, $parts)) {
            $fraction = floatval($parts[1]);
            
            if ($fraction !== 0.0) {
                $result .= ' ' . $config->getConjunction() . ' ' . $numberFormatter->format($fraction)  . ' ' . $config->getFraction($fraction);
            }
        }
        
        return $result;
    }
}
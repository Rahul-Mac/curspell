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
    
        $base = intval($parts[0]);

        $result = $conjunction = '';

        if ($base !== 0) {
            $result = $numberFormatter->format($base) . ' ' . $config->getBase($base);
            $conjunction = ' ' . $config->getConjunction() . ' ';
        }

        if (key_exists(1, $parts)) {
            $fraction = intval($parts[1]);
            
            if ($fraction !== 0) {
                $result .= $conjunction . $numberFormatter->format($fraction)  . ' ' . $config->getFraction($fraction);
            }
        }
        
        return $result;
    }
}
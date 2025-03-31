<?php

namespace Rahulmac\Curspell;

use Rahulmac\Curspell\Config\Configuration;
use Rahulmac\Curspell\Exceptions\UnknownLocaleException;
use Rahulmac\Curspell\Exceptions\UnknownCurrencyCodeException;

/**
 * The Currency Speller.
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
     * The currency code.
     */
    private string $code = 'USD';

    /**
     * The locale.
     */
    private string $locale = 'en_US';

    /**
     * Set the currency code.
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Set the locale.
     */
    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Spell the amount.
     *
     * @throws UnknownLocaleException If the locale is invalid or unsupported
     * @throws \InvalidArgumentException If the amount is not numeric
     * @throws UnknownCurrencyCodeException If the currency code is invalid or unsupported
     */
    public function spell(mixed $amount): string
    {
        if (! \is_numeric($amount)) {
            throw new \InvalidArgumentException('The given amount is not numeric');
        }

        $amount = \floatval($amount);
        $result = $conjunction = '';

        if ($amount === 0.0) {
            return $result;
        }

        $base = $amount < 0 ? \ceil($amount) : \floor($amount);
        // Return the absolute value as the sign of the fraction doesn't matter
        $fraction = \abs($amount - $base);

        $config = new Configuration($this->code, $this->locale);

        $numberFormatter = new \NumberFormatter($this->locale, \NumberFormatter::SPELLOUT);

        if ($base !== 0.0) {
            $result = $numberFormatter->format($base) . ' ' . $config->getBase($base);
            // A scenario may occur where the base is 0 but the fraction exist. (Eg. $0.2)
            // If we render the conjunction while spelling the fraction it will display
            // "and twenty cents" which is incorrect. It should be "twenty cents".
            $conjunction = ' ' . $config->getConjunction() . ' ';
        }

        if ($fraction !== 0.0) {
            $subunit = $config->getSubunit();
            $fraction = \round($fraction, $this->getPrecision($subunit)) * $subunit;
            $result .= $conjunction . $numberFormatter->format($fraction)  . ' ' . $config->getFraction($fraction);
        }

        return $result;
    }

    /**
     * Return the number of digits to round to based on the subunit.
     *
     * The precision should be one less than the number of digits of the subunit.
     *
     * Eg: A subunit of 100 should have a precision of 2.
     */
    private function getPrecision(int $subunit): int
    {
        return $subunit !== 0 ? \floor(\log10($subunit)) : 0;
    }
}

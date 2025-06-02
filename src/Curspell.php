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
     * @throws UnknownLocaleException If the locale is invalid or unsupported.
     * @throws \InvalidArgumentException If the amount is not numeric.
     * @throws UnknownCurrencyCodeException If the currency code is invalid or unsupported.
     */
    public function spell(mixed $amount): string
    {
        if (! \is_numeric($amount)) {
            throw new \InvalidArgumentException('The given amount is not numeric');
        }

        $amount = (string) $amount;
        $isNegative = \bccomp($amount, '0', 10) < 0;
        $absAmount = \ltrim($amount, '-');

        $config = new Configuration($this->code, $this->locale);
        $subunit = $config->getSubunit();
        $numberFormatter = new \NumberFormatter($this->locale, \NumberFormatter::SPELLOUT);

        $precision = $this->getPrecision($subunit);
        $rounded = $this->round($absAmount, $precision);
        $amountInSubunits = \bcmul($rounded, (string) $subunit, 0);

        $base = \bcdiv($amountInSubunits, (string) $subunit);
        $fraction = \bcmod($amountInSubunits, (string) $subunit);

        $parts = [];

        if ($isNegative) {
            $parts[] = 'minus';
        }

        if ((int) $base > 0) {
            $baseWord = $numberFormatter->format((int) $base);
            $parts[] = $baseWord . ' ' . $config->getBase((int) $base);
        }

        if ((int) $fraction > 0) {
            $fractionWord = $numberFormatter->format((int) $fraction);
            $fractionText = $fractionWord . ' ' . $config->getFraction((int) $fraction);

            if ((int) $base > 0) {
                $parts[] = $config->getConjunction();
            }

            $parts[] = $fractionText;
        }

        return \implode(' ', $parts);
    }

    /**
     * Return the number of digits to round to based on the subunit.
     */
    private function getPrecision(int $subunit): int
    {
        if ($subunit <= 0) {
            return 0;
        }

        $fraction = \bcdiv('1', (string) $subunit, 10);
        $decimal = \rtrim($fraction, '0');
        $pos = \strpos($decimal, '.');

        return $pos !== false ? \strlen($decimal) - $pos - 1 : 0;
    }

    /**
     * Round a BCMath number to a given precision (half-up).
     */
    private function round(string $number, int $precision): string
    {
        if ($precision < 0) {
            throw new \InvalidArgumentException('Precision must be non-negative');
        }

        $factor = \bcpow('10', (string) ($precision + 1));
        $scaled = \bcmul($number, $factor, 0);
        $lastDigit = (int) \substr($scaled, -1);
        $truncated = \bcdiv($scaled, '10');

        if ($lastDigit >= 5) {
            $truncated = \bcadd($truncated, '1');
        }

        return \bcdiv($truncated, \bcpow('10', (string) $precision), $precision);
    }
}

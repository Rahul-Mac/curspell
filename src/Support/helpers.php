<?php

namespace Rahulmac\Curspell\Support;

use Rahulmac\Curspell\Curspell;
use Rahulmac\Curspell\Exceptions\UnknownCurrencyCodeException;
use Rahulmac\Curspell\Exceptions\UnknownLocaleException;

if (! \function_exists('Rahulmac\Curspell\Support\curspell')) {
    /**
     * Spell the amount.
     *
     * @throws UnknownLocaleException
     * @throws \InvalidArgumentException
     * @throws UnknownCurrencyCodeException
     */
    function curspell(mixed $amount, string $code = 'USD', string $locale = 'en_US'): string
    {
        return (new Curspell())->setCode($code)->setLocale($locale)->spell($amount);
    }
}

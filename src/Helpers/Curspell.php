<?php

namespace Rahulmac\Curspell\Helpers;

use Rahulmac\Curspell\Curspell as CurrencySpeller;

/**
 * Static helper class for Curspell
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
     * Spell the amount as United Arab Emirates Dirham
     */
    public static function aed(mixed $amount): string
    {
        return static::spell($amount, 'AED', 'en');
    }

    /**
     * Spell the amount as Albanian lek
     */
    public static function all(mixed $amount): string
    {
        return static::spell($amount, 'ALL', 'en');
    }

    /**
     * Spell the amount as Indian Rupee
     */
    public static function inr(mixed $amount): string
    {
        return static::spell($amount, 'INR', 'en_IN');
    }

    /**
     * Spell the amount as United States Dollar
     */
    public static function usd(mixed $amount): string
    {
        return (new CurrencySpeller())->spell($amount);
    }

    /**
     * Spell the amount as Pound Sterling
     */
    public static function gbp(mixed $amount): string
    {
        return static::spell($amount, 'GBP', 'en_GB');
    }

    private static function spell(mixed $amount, string $code, string $locale): string
    {
        return (new CurrencySpeller())->setCode($code)->setLocale($locale)->spell($amount);
    }
}
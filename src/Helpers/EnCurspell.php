<?php

namespace Rahulmac\Curspell\Helpers;

use Rahulmac\Curspell\Curspell;

/**
 * Static helper class for spelling the currency amounts in the English language
 * 
 * @package Curspell
 * 
 * @author Rahul Mac <rahulmacwan14@gmail.com>
 * 
 * @copyright (c) 2025
 * 
 * @license https://opensource.org/licenses/MIT MIT License
 */
final class EnCurspell
{
    /**
     * Spell the amount as United Arab Emirates Dirham
     */
    public static function aed(mixed $amount): string
    {
        return static::spell($amount, 'AED');
    }

    /**
     * Spell the amount as United Arab Emirates Dirham
     */
    public static function afn(mixed $amount): string
    {
        return static::spell($amount, 'AFN');
    }

    /**
     * Spell the amount as Albanian lek
     */
    public static function all(mixed $amount): string
    {
        return static::spell($amount, 'ALL');
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
        return (new Curspell())->spell($amount);
    }

    /**
     * Spell the amount as Pound Sterling
     */
    public static function gbp(mixed $amount): string
    {
        return static::spell($amount, 'GBP', 'en_GB');
    }

    /**
     * Spell the amount as Euro
     */
    public static function eur(mixed $amount): string
    {
        return static::spell($amount, 'EUR');
    }

    private static function spell(mixed $amount, string $code, string $locale= 'en'): string
    {
        return (new Curspell())->setCode($code)->setLocale($locale)->spell($amount);
    }
}
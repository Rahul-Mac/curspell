<?php

namespace Tests\Unit;

use Tests\TestCase;
use ReflectionClass;
use Rahulmac\Curspell\Curspell;
use Rahulmac\Curspell\Exceptions\UnknownCurrencyCodeException;

final class CurspellTest extends TestCase
{
    private Curspell $curspell;

    protected function setUp(): void
    {
        parent::setUp();

        $this->curspell = new Curspell();
    }

    public function testSetCode(): void
    {
        $this->curspell->setCode('EUR');
        $reflection = new ReflectionClass($this->curspell);
        $codeProperty = $reflection->getProperty('code');
        $codeProperty->setAccessible(true);

        $this->assertEquals('EUR', $codeProperty->getValue($this->curspell));
    }

    public function testSetLocale(): void
    {
        $this->curspell->setLocale('en_IN');
        $reflection = new ReflectionClass($this->curspell);
        $localeProperty = $reflection->getProperty('locale');
        $localeProperty->setAccessible(true);

        $this->assertEquals('en_IN', $localeProperty->getValue($this->curspell));
    }

    public function testSpellWholeNumber(): void
    {
        $this->assertEquals('one hundred twenty-three dollars', $this->curspell->setCode('USD')->setLocale('en_US')->spell(123));
    }

    public function testSpellWithFraction(): void
    {
        $this->assertEquals('one hundred twenty-three dollars and forty-five cents', $this->curspell->setCode('USD')->setLocale('en_US')->spell(123.45));
    }

    public function testSpellWithZeroFraction(): void
    {
        $this->assertEquals('one hundred twenty-three dollars', $this->curspell->setCode('USD')->setLocale('en_US')->spell(123.00));
    }

    public function testSpellNegativeAmount(): void
    {
        $this->assertEquals('minus one hundred twenty-three dollars and forty-five cents', $this->curspell->setCode('USD')->setLocale('en_US')->spell(-123.45));
    }

    public function testSpellDifferentCurrencyandLocale(): void
    {        
        $this->assertEquals('ninety-nine pounds and ninety-nine pence', $this->curspell->setCode('GBP')->setLocale('en_GB')->spell(99.99));
    }

    public function testUnknownCurrency(): void
    {
        $this->expectException(UnknownCurrencyCodeException::class);

        $this->curspell->setCode('ABC')->spell(100);    
    }
}
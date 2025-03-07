<?php

namespace Rahulmac\Curspell\Tests\Unit;

use Rahulmac\Curspell\Curspell;
use Rahulmac\Curspell\Exceptions\UnknownCurrencyCodeException;
use Rahulmac\Curspell\Tests\TestCase;
use ReflectionClass;

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

    public function testSpellWithZeroBase(): void
    {
        $this->assertEquals('twelve paise', $this->curspell->setCode('INR')->setLocale('en_IN')->spell(0.12));
    }

    public function testSpellNegativeAmount(): void
    {
        $this->assertEquals('minus one hundred twenty-three dollars and forty-five cents', $this->curspell->setCode('USD')->setLocale('en_US')->spell(-123.45));
    }

    public function testSpellDifferentCurrencyandLocale(): void
    {
        $this->assertEquals('ninety-nine pounds and ninety-nine pence', $this->curspell->setCode('GBP')->setLocale('en_GB')->spell(99.99));
    }

    public function testSpellZero(): void
    {
        $this->assertEquals('', $this->curspell->spell(0));
    }

    public function testUnknownCurrency(): void
    {
        $this->expectException(UnknownCurrencyCodeException::class);

        $this->curspell->setCode('ABC')->spell(100);
    }

    public function testSpellWithDifferentSubunit(): void
    {
        $this->assertEquals('two hundred dinar and four hundred fils', $this->curspell->setCode('BHD')->setLocale('en')->spell(200.4));
    }
}

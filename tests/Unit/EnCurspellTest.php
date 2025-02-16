<?php

namespace Rahulmac\Curspell\Tests\Unit;

use Rahulmac\Curspell\Tests\TestCase;
use Rahulmac\Curspell\Helpers\EnCurspell;

final class EnCurspellTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testSpellAed(): void
    {
        $this->assertEquals('one hundred twenty-three dirhams and forty-five fils', EnCurspell::aed(123.45));
    }

    public function testSpellAll(): void
    {
        $this->assertEquals('one hundred twenty-three leks and forty-five qintars', EnCurspell::all(123.45));
    }

    public function testSpellInr(): void
    {
        $this->assertEquals('one hundred twenty-three rupees and forty-five paise', EnCurspell::inr(123.45));
    }

    public function testSpellEur(): void
    {
        $this->assertEquals('one hundred twenty-three euros and forty-five cents', EnCurspell::eur(123.45));
    }

    public function testSpellGbp(): void
    {
        $this->assertEquals('one hundred twenty-three pounds and forty-five pence', EnCurspell::gbp(123.45));
    }

    public function testSpellUsd(): void
    {
        $this->assertEquals('one hundred twenty-three dollars and forty-five cents', EnCurspell::usd(123.45));
    }
}
<?php

namespace Tests\Unit;

use Tests\TestCase;
use Rahulmac\Curspell\Helpers\Curspell;

final class CurspellHelperTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testSpellAed(): void
    {
        $this->assertEquals('one hundred twenty-three dirhams and forty-five fils', Curspell::aed(123.45));
    }

    public function testSpellAll(): void
    {
        $this->assertEquals('one hundred twenty-three leks and forty-five qintars', Curspell::all(123.45));
    }
}
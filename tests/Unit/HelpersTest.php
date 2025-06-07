<?php

namespace Rahulmac\Curspell\Tests\Unit;

use Rahulmac\Curspell\Tests\TestCase;

use function Rahulmac\Curspell\Support\curspell;

class HelpersTest extends TestCase
{
    public function testSpellAmountWithDefaultCurrencyAndLocale()
    {
        $amount = 1234.56;
        $result = curspell($amount);

        // Assuming the expected result in USD is "one thousand two hundred thirty-four dollars and fifty-six cents"
        $this->assertEquals("one thousand two hundred thirty-four dollars and fifty-six cents", $result);
    }

    public function testSpellAmountWithCustomCurrencyCode()
    {
        $amount = 1234.56;
        $result = curspell($amount, 'EUR', 'en');

        $this->assertEquals("one thousand two hundred thirty-four euros and fifty-six cents", $result);
    }
}

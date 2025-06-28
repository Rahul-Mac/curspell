<?php

namespace Rahulmac\Curspell\Tests\Unit;

use Rahulmac\Curspell\Exceptions\UnknownCurrencyCodeException;
use Rahulmac\Curspell\Exceptions\UnknownLocaleException;
use function Rahulmac\Curspell\Support\curspell;

use Rahulmac\Curspell\Tests\TestCase;

class HelpersTest extends TestCase
{
    /**
     * @throws UnknownCurrencyCodeException
     * @throws UnknownLocaleException
     */
    public function testSpellAmountWithDefaultCurrencyAndLocale()
    {
        $amount = 1234.56;
        $result = curspell($amount);

        // Assuming the expected result in USD is "one thousand two hundred thirty-four dollars and fifty-six cents"
        $this->assertEquals("one thousand two hundred thirty-four dollars and fifty-six cents", $result);
    }

    /**
     * @throws UnknownLocaleException
     * @throws UnknownCurrencyCodeException
     */
    public function testSpellAmountWithCustomCurrencyCode()
    {
        $amount = 1234.56;
        $result = curspell($amount, 'EUR', 'en');

        $this->assertEquals("one thousand two hundred thirty-four euros and fifty-six cents", $result);
    }
}

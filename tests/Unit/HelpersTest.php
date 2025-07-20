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
        $this->assertEquals("one thousand two hundred thirty-four dollars and fifty-six cents", curspell(1234.56));
    }

    /**
     * @throws UnknownLocaleException
     * @throws UnknownCurrencyCodeException
     */
    public function testSpellAmountWithCustomCurrencyCode()
    {
        $this->assertEquals(
            "one thousand two hundred thirty-four euros and fifty-six cents",
            curspell(1234.56, 'EUR', 'en'),
        );
    }
}

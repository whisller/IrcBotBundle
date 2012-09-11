<?php

namespace Whisnet\IrcBotBundle\Tests\Utils;

use Whisnet\IrcBotBundle\Utils\Utils;

class UtilsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideEndOfLineTexts
     */
    public function testThatEndOfLineMarkersAreRemoved($text, $expectedResult)
    {
        $result = Utils::cleanUpServerRequest($text);

        $this->assertSame($expectedResult, $result);
    }

    public function provideEndOfLineTexts()
    {
        return array(
            array('Lorem ipsum', 'Lorem ipsum'),
            array("Lorem ipsum\r\n", 'Lorem ipsum'),
            array("\rLorem\nipsum", 'Loremipsum'),
            array("Lorem \ripsum", 'Lorem ipsum')
        );
    }
}

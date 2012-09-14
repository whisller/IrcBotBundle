<?php
namespace Whisnet\IrcBotBundle\Tests\IrcCommands;

use Whisnet\IrcBotBundle\IrcCommands\NamesCommand;

class NamesCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test__toStringEmptyList()
    {
        $this->assertEquals("NAMES\r", (string)new NamesCommand());
    }

    public function test__toStringOneChannel()
    {
        $this->assertEquals("NAMES #foo\r", (string)new NamesCommand(array('#foo')));
    }

    public function test__toStringTwoChannels()
    {
        $this->assertEquals("NAMES #foo,#bar\r", (string)new NamesCommand(array('#foo', '#bar')));
    }

    public function test__toStringTwoMixedChannels()
    {
        $this->assertEquals("NAMES #foo,&bar\r", (string)new NamesCommand(array('#foo', '&bar')));
    }
}

<?php
namespace Whisnet\IrcBotBundle\Tests\IrcCommands;

use Whisnet\IrcBotBundle\IrcCommands\PartCommand;

class PartCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test__toString_OneChannel()
    {
        $this->assertEquals("PART #foo\r", (string)new PartCommand(array('#foo')));
    }

    public function test__toString_OneChannelWithMessage()
    {
        $this->assertEquals("PART #foo bar\r", (string)new PartCommand(array('#foo'), 'bar'));
    }

    public function test__toString_TwoChannels()
    {
        $this->assertEquals("PART #foo,#bar\r", (string)new PartCommand(array('#foo', '#bar')));
    }

    public function test__toString_TwoChannelsWithMessage()
    {
        $this->assertEquals("PART #foo,#bar foobar\r", (string)new PartCommand(array('#foo', '#bar'), 'foobar'));
    }
}

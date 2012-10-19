<?php
namespace Whisnet\IrcBotBundle\Tests\IrcCommands;

use Whisnet\IrcBotBundle\IrcCommands\ChannelModeCommand;

class ChannelModeCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test__toString()
    {
        $this->assertEquals("MODE #foo -s\r", (string) new ChannelModeCommand('#foo', '-s'));
    }

    public function test__toString_WithModeParams()
    {
        $this->assertEquals("MODE #foo +v bar\r", (string) new ChannelModeCommand('#foo', '+v', 'bar'));
    }
}

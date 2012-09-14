<?php
namespace Whisnet\IrcBotBundle\Tests\IrcCommands;

use Whisnet\IrcBotBundle\IrcCommands\TimeCommand;

class TimeCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test__toString()
    {
        $this->assertEquals("TIME\r", (string)new TimeCommand());
    }

    public function test__toString_WithTarget()
    {
        $this->assertEquals("TIME foo.bar.com\r", (string)new TimeCommand('foo.bar.com'));
    }
}

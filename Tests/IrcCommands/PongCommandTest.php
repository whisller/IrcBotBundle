<?php
namespace Whisnet\IrcBotBundle\Tests\IrcCommands;

use Whisnet\IrcBotBundle\IrcCommands\PongCommand;

class PongCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test__toString_OneServer()
    {
        $this->assertEquals("PONG foo.bar.com\r", (string) new PongCommand(array('foo.bar.com')));
    }

    public function test__toString_TwoServers()
    {
        $this->assertEquals("PONG foo.bar.com bar.foo.com\r", (string) new PongCommand(array('foo.bar.com', 'bar.foo.com')));
    }
}

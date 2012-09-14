<?php
namespace Whisnet\IrcBotBundle\Tests\IrcCommands;

use Whisnet\IrcBotBundle\IrcCommands\UserModeCommand;

class UserModeCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test__toString_AddOneMode()
    {
        $this->assertEquals("MODE foo +i\r", (string)new UserModeCommand('foo', '+i'));
    }

    public function test__toString_RemoveOneMode()
    {
        $this->assertEquals("MODE foo -i\r", (string)new UserModeCommand('foo', '-i'));
    }
}

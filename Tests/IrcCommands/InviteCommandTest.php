<?php
namespace Whisnet\IrcBotBundle\Tests\IrcCommands;

use Whisnet\IrcBotBundle\IrcCommands\InviteCommand;

class InviteCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test__toString()
    {
        $this->assertEquals("INVITE abc #xyz\r", (string)new InviteCommand('abc', '#xyz'));
    }
}

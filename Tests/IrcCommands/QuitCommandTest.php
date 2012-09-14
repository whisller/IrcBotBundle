<?php
namespace Whisnet\IrcBotBundle\Tests\IrcCommands;

use Whisnet\IrcBotBundle\IrcCommands\QuitCommand;
use Whisnet\IrcBotBundle\Message\Message;

class QuitCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test__toString_WithoutMessage()
    {
        $this->assertEquals("QUIT\r", (string)new QuitCommand());
    }

    public function test__toString_WithMessage()
    {
        $this->assertEquals("QUIT :fuu\r", (string)new QuitCommand(new Message('fuu')));
    }

    public function test__toString_WithMessageWithTwoWords()
    {
        $this->assertEquals("QUIT :fuu bar\r", (string)new QuitCommand(new Message('fuu bar')));
    }
}

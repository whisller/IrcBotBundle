<?php
namespace Whisnet\IrcBotBundle\Tests\IrcCommands;

use Whisnet\IrcBotBundle\IrcCommands\UserCommand;

class UserCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test__toString()
    {
        $this->assertEquals("USER foo 0 * :foo\r", (string) new UserCommand('foo', 0, 'foo'));
    }

    public function test__toString_WithoutRealname()
    {
        $this->assertEquals("USER foo 0 * :foo\r", (string) new UserCommand('foo', 0));
    }

    public function test__toString_WithRealnameAsTwoWords()
    {
        $this->assertEquals("USER foo 0 * :foo bar\r", (string) new UserCommand('foo', 0, 'foo bar'));
    }
}

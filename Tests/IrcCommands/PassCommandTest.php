<?php
namespace Whisnet\IrcBotBundle\Tests\IrcCommands;

use Whisnet\IrcBotBundle\IrcCommands\PassCommand;

class PassCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test__toString()
    {
        $this->assertEquals("PASS foo\r", (string) new PassCommand('foo'));
    }
}

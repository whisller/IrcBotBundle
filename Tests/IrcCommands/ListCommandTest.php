<?php
namespace Whisnet\IrcBotBundle\Tests\IrcCommands;

use Whisnet\IrcBotBundle\IrcCommands\ListCommand;

class ListCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test__toStringEmptyList()
    {
        $this->assertEquals("LIST\r", (string)new ListCommand());
    }

    public function test__toStringOneChannel()
    {
        $this->assertEquals("LIST #foo\r", (string)new ListCommand(array('#foo')));
    }

    public function test__toStringTwoChannels()
    {
        $this->assertEquals("LIST #foo,#bar\r", (string)new ListCommand(array('#foo', '#bar')));
    }

    public function test__toStringTwoMixedChannels()
    {
        $this->assertEquals("LIST #foo,&bar\r", (string)new ListCommand(array('#foo', '&bar')));
    }
}

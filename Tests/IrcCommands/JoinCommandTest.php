<?php
namespace Whisnet\IrcBotBundle\Tests\IrcCommands;

use Whisnet\IrcBotBundle\IrcCommands\JoinCommand;

class JoinCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test__toString_OneChannel()
    {
        $this->assertEquals("JOIN #foo\r", (string)new JoinCommand(array('#foo')));
    }

    public function test__toString_OneChannelWithAmpersand()
    {
        $this->assertEquals("JOIN &foo\r", (string)new JoinCommand(array('&foo')));
    }

    public function test__toString_OneChannelOneKey()
    {
        $this->assertEquals("JOIN #foo fubar\r", (string)new JoinCommand(array('#foo'), array('fubar')));
    }

    public function test__toString_OneChannelWithAmpersandOneKey()
    {
        $this->assertEquals("JOIN &foo fubar\r", (string)new JoinCommand(array('&foo'), array('fubar')));
    }

    public function test__toString_TwoChannels()
    {
        $this->assertEquals("JOIN #foo,#bar\r", (string)new JoinCommand(array('#foo', '#bar')));
    }

    public function test__toString_TwoChannelsWithAmpersand()
    {
        $this->assertEquals("JOIN &foo,&bar\r", (string)new JoinCommand(array('&foo', '&bar')));
    }

    public function test__toString_TwoChannelsOneKey()
    {
        $this->assertEquals("JOIN #foo,#bar fubar\r", (string)new JoinCommand(array('#foo', '#bar'), array('fubar')));
    }

    public function test__toString_TwoChannelsWithAmpersandOneKey()
    {
        $this->assertEquals("JOIN &foo,&bar fubar\r", (string)new JoinCommand(array('&foo', '&bar'), array('fubar')));
    }

    public function test__toString_TwoChannelsTwoKeys()
    {
        $this->assertEquals("JOIN #foo,#bar fubar,foobar\r", (string)new JoinCommand(array('#foo', '#bar'), array('fubar', 'foobar')));
    }

    public function test__toString_TwoChannelsWithAmpersandTwoKeys()
    {
        $this->assertEquals("JOIN &foo,&bar fubar,foobar\r", (string)new JoinCommand(array('&foo', '&bar'), array('fubar', 'foobar')));
    }

    public function test__toString_TwoChannelsWithMixedName()
    {
        $this->assertEquals("JOIN &foo,#bar\r", (string)new JoinCommand(array('&foo', '#bar')));
    }

    public function test__toString_LeaveAllChannels()
    {
        $this->assertEquals("JOIN 0\r", (string)new JoinCommand(array(0)));
    }
}

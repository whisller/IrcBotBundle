<?php
namespace Whisnet\IrcBotBundle\Tests\IrcCommands;

use Whisnet\IrcBotBundle\IrcCommands\PrivMsgCommand;
use Whisnet\IrcBotBundle\Message\Message;

class PrivMsgCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test__toString_OneReceiverAsChannel()
    {
        $this->assertEquals("PRIVMSG #foo :bar\r", (string) new PrivMsgCommand(array('#foo'), new Message('bar')));
    }

    public function test__toString_OneReceiverAsUser()
    {
        $this->assertEquals("PRIVMSG foo :bar\r", (string) new PrivMsgCommand(array('foo'), new Message('bar')));
    }

    public function test__toString_TwoReceiversAsChannels()
    {
        $this->assertEquals("PRIVMSG #foo,#bar :fuu\r", (string) new PrivMsgCommand(array('#foo', '#bar'), new Message('fuu')));
    }

    public function test__toString_TwoReceiversAsUsers()
    {
        $this->assertEquals("PRIVMSG foo,bar :fuu\r", (string) new PrivMsgCommand(array('foo', 'bar'), new Message('fuu')));
    }

    public function test__toString_TwoMixedReceivers()
    {
        $this->assertEquals("PRIVMSG foo,#bar :fuu\r", (string) new PrivMsgCommand(array('foo', '#bar'), new Message('fuu')));
    }

    public function test__toString_TwoMixedReceiversMessageWithTwoWords()
    {
        $this->assertEquals("PRIVMSG foo,#bar :fuu bar\r", (string) new PrivMsgCommand(array('foo', '#bar'), new Message('fuu bar')));
    }
}

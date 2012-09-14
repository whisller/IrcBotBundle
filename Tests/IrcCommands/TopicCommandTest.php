<?php
namespace Whisnet\IrcBotBundle\Tests\IrcCommands;

use Whisnet\IrcBotBundle\IrcCommands\TopicCommand;

class TopicCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test__toString_CheckTopic()
    {
        $this->assertEquals("TOPIC #foo\r", (string)new TopicCommand('#foo'));
    }

    public function test__toString_CheckTopicAmpersandChannel()
    {
        $this->assertEquals("TOPIC &foo\r", (string)new TopicCommand('&foo'));
    }

    public function test__toString_ClearTopic()
    {
        $this->assertEquals("TOPIC #foo :\r", (string)new TopicCommand('#foo', ''));
    }

    public function test__toString_ClearTopicInAmpersandChannel()
    {
        $this->assertEquals("TOPIC &foo :\r", (string)new TopicCommand('&foo', ''));
    }

    public function test_toString_SetTopic()
    {
        $this->assertEquals("TOPIC #foo :bar\r", (string)new TopicCommand('#foo', 'bar'));
    }

    public function test_toString_SetTopicWithAmpersand()
    {
        $this->assertEquals("TOPIC &foo :bar\r", (string)new TopicCommand('&foo', 'bar'));
    }

    public function test_toString_SetTopicWithTwoWords()
    {
        $this->assertEquals("TOPIC #foo :bar fuu\r", (string)new TopicCommand('#foo', 'bar fuu'));
    }

    public function test_toString_SetTopicWithAmpersandWithTwoWords()
    {
        $this->assertEquals("TOPIC &foo :bar fuu\r", (string)new TopicCommand('&foo', 'bar fuu'));
    }
}

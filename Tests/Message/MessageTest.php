<?php
namespace Whisnet\IrcBotBundle\Tests\Message;

use Whisnet\IrcBotBundle\Message\Message;

class NickCommandTest extends \PHPUnit_Framework_TestCase
{
    public function test__toString()
    {
        $this->assertEquals("foo", (string)new Message('foo'));
    }
}

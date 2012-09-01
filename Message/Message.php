<?php
namespace Whisnet\IrcBotBundle\Message;

class Message implements MessageInterface
{
    private $msg = '';

    public function __construct($msg)
    {
        $this->msg = $msg;
    }

    public function __toString()
    {
        return $this->msg;
    }
}

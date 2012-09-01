<?php
namespace Whisnet\IrcBotBundle\Message;

abstract class MessageDecorator implements MessageInterface
{
    private $decorator;

    public function __construct(MessageInterface $decorator)
    {
        $this->decorator = $decorator;
    }

    public function __toString()
    {
        return $this->decorator->toString();
    }
}

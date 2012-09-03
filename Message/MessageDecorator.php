<?php
namespace Whisnet\IrcBotBundle\Message;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
abstract class MessageDecorator implements MessageInterface
{
    /**
     * @var MessageInterface
     */
    private $decorator;

    /**
     * @param MessageInterface $decorator
     */
    public function __construct(MessageInterface $decorator)
    {
        $this->decorator = $decorator;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->decorator->toString();
    }
}

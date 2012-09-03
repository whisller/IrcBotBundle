<?php
namespace Whisnet\IrcBotBundle\Message;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class Message implements MessageInterface
{
    /**
     * @var string
     */
    private $msg = '';

    /**
     * @param string $msg
     */
    public function __construct($msg)
    {
        $this->msg = $msg;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->msg;
    }
}

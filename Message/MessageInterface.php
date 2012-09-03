<?php
namespace Whisnet\IrcBotBundle\Message;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
interface MessageInterface
{
    /**
     * @return string
     */
    public function __toString();
}

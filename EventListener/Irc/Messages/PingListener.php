<?php
namespace Whisnet\IrcBotBundle\EventListener\Irc\Messages;

use Whisnet\IrcBotBundle\Event\BaseIrcEvent;

use Whisnet\IrcBotBundle\IrcCommands\PongCommand;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */

class PingListener
{
    /**
     * @param BaseIrcEvent $event
     */
    public function onData(BaseIrcEvent $event)
    {
        $data = $event->getData();

        $event->getConnection()->sendCommand(new PongCommand(array($data[4])));
    }
}
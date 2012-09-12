<?php
namespace Whisnet\IrcBotBundle\EventListener\Irc\Messages;

use Whisnet\IrcBotBundle\EventListener\Irc\BaseIrcListener;
use Whisnet\IrcBotBundle\Event\BaseIrcEvent;
use Whisnet\IrcBotBundle\IrcCommands\PongCommand;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */

class PingListener extends BaseIrcListener
{
    /**
     * @param BaseIrcEvent $event
     */
    public function onData(BaseIrcEvent $event)
    {
        $data = $event->getData();

        $this->connection->sendCommand(new PongCommand(array($data[4])));
    }
}
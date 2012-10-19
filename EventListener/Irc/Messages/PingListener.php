<?php
namespace Whisnet\IrcBotBundle\EventListener\Irc\Messages;

use Whisnet\IrcBotBundle\EventListener\Irc\BaseIrcListener;
use Whisnet\IrcBotBundle\Event\IrcCommandFoundEvent;
use Whisnet\IrcBotBundle\IrcCommands\PongCommand;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */

class PingListener extends BaseIrcListener
{
    /**
     * @param IrcCommandFoundEvent $event
     */
    public function onData(IrcCommandFoundEvent $event)
    {
        $data = $event->getData();

        $this->connection->sendCommand(new PongCommand(array($data[4])));
    }
}

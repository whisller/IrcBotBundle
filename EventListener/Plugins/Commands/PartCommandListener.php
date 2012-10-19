<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins\Commands;

use Whisnet\IrcBotBundle\EventListener\Plugins\Commands\CommandListener;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;
use Whisnet\IrcBotBundle\Message\Message;
use Whisnet\IrcBotBundle\IrcCommands\PartCommand;

/**
 * Leave channels specified by user.
 * If no channel is specified leave from current channel.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class PartCommandListener extends CommandListener
{
    /**
     * {@inheritdoc}
     */
    public function onCommand(BotCommandFoundEvent $event)
    {
        $data = $event->getArguments();

        $this->connection->sendCommand(new PartCommand(array($data[0]), new Message((isset($data[1]) ? $data[1] : ''))));
    }
}

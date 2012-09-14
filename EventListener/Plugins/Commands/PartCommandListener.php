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
     * @param BotCommandFoundEvent $event
     * @throws CommandException
     * @return boolean
     */
    public function onCommand(BotCommandFoundEvent $event)
    {
        $data = $event->getArguments();

        $this->connection->sendCommand(new PartCommand(new Message((isset($data[0]) ? $data[0] : ''))));
    }
}
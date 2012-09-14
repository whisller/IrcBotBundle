<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins\Commands;

use Whisnet\IrcBotBundle\EventListener\Plugins\Commands\CommandListener;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;
use Whisnet\IrcBotBundle\IrcCommands\JoinCommand;

/**
 * Join to channels specified by user.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class JoinCommandListener extends CommandListener
{
    /**
     * {@inheritdoc}
     */
    public function onCommand(BotCommandFoundEvent $event)
    {
        $this->connection->sendCommand(new JoinCommand($event->getArguments()));
    }
}

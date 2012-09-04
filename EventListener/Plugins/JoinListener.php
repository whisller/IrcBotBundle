<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins;

use Whisnet\IrcBotBundle\EventListener\Plugins\BaseListener;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;

use Whisnet\IrcBotBundle\IrcCommands\JoinCommand;

/**
 * Join to channels specified by user.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class JoinListener extends BaseListener
{
    /**
     * @param BotCommandFoundEvent $event
     * @throws CommandException
     * @return boolean
     */
    public function onCommand(BotCommandFoundEvent $event)
    {
        $joinCommand = new JoinCommand($this->validator);
        foreach ($event->getArguments() as $channel) {
            $joinCommand->addChannel($channel);
        }
        $joinCommand->validate();

        $event->getConnection()->sendData((string)$joinCommand);
    }
}

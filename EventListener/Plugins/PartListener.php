<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins;

use Whisnet\IrcBotBundle\EventListener\Plugins\BaseListener;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;

use Whisnet\IrcBotBundle\IrcCommands\PartCommand;

/**
 * Leave channels specified by user.
 * If no channel is specified leave from current channel.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class PartListener extends BaseListener
{
    /**
     * @param BotCommandFoundEvent $event
     * @throws CommandException
     * @return boolean
     */
    public function onCommand(BotCommandFoundEvent $event)
    {
        $partCommand = new PartCommand($this->validator);

        if (0 === count($event->getArguments())) {
            $partCommand->addChannel($event->getChannel());
        } else {
            foreach ($event->getArguments() as $channel) {
                $partCommand->addChannel($channel);
            }
        }

        $partCommand->validate();

        $event->getConnection()->sendData((string)$partCommand);
    }
}
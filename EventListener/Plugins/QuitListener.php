<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins;

use Whisnet\IrcBotBundle\EventListener\Plugins\BaseListener;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;

use Whisnet\IrcBotBundle\Message\Message;
use Whisnet\IrcBotBundle\IrcCommands\QuitCommand;

/**
 * Allow user to quit bot by command.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class QuitListener extends BaseListener
{
    /**
     * @param BotCommandFoundEvent $event
     * @throws CommandException
     * @return boolean
     */
    public function onCommand(BotCommandFoundEvent $event)
    {
        $quitCommand = new QuitCommand($this->validator);
        $quitCommand->setMessage((string)new Message($event->getNickname()))
                ->validate();

        $event->getConnection()->sendData((string)$quitCommand);
    }
}
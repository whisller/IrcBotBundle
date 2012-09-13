<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins\Commands;

use Whisnet\IrcBotBundle\EventListener\Plugins\Commands\CommandListener;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;
use Whisnet\IrcBotBundle\Annotations as ircbot;
use Whisnet\IrcBotBundle\Message\Message;
use Whisnet\IrcBotBundle\IrcCommands\QuitCommand;

/**
 * Allow user to quit bot by command.
 *
 * @ircbot\CommandInfo(name="quit", help="Terminate the IrcBotBundle")
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class QuitCommandListener extends CommandListener
{
    /**
     * @param BotCommandFoundEvent $event
     * @throws CommandException
     * @return boolean
     */
    public function onCommand(BotCommandFoundEvent $event)
    {
        $data = $event->getArguments();

        $event->getConnection()->sendCommand(new QuitCommand(new Message((isset($data[0]) ? $data[0] : ''))));
    }
}
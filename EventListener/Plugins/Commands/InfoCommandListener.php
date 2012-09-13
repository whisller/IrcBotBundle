<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins\Commands;

use Whisnet\IrcBotBundle\EventListener\Plugins\Commands\CommandListener;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;
use Whisnet\IrcBotBundle\Annotations as ircbot;

/**
 * Get information about bot.
 *
 * @ircbot\CommandInfo(name="info", help="Display simple info about IrcBot")
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class InfoCommandListener extends CommandListener
{
    /**
     * @param BotCommandFoundEvent $event
     * @throws CommandException
     * @return boolean
     */
    public function onCommand(BotCommandFoundEvent $event)
    {
        $msg = 'Hi! My name is IrcBotBundle, you can find me on github (https://github.com/whisller/IrcBotBundle).';

        $this->sendMessage($event, array($event->getChannel()), $msg);
    }
}

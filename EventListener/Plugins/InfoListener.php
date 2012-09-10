<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins;

use Whisnet\IrcBotBundle\EventListener\Plugins\BasePluginListener;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;

/**
 * Get information about bot.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class InfoListener extends BasePluginListener
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

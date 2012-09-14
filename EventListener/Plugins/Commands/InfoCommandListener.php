<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins\Commands;

use Whisnet\IrcBotBundle\EventListener\Plugins\Commands\CommandListener;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;

/**
 * Get information about bot.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class InfoCommandListener extends CommandListener
{
    /**
     * {@inheritdoc}
     */
    public function onCommand(BotCommandFoundEvent $event)
    {
        $msg = 'Hi! My name is IrcBotBundle, you can find me on github (https://github.com/whisller/IrcBotBundle).';

        $this->sendMessage(array($event->getChannel()), $msg);
    }
}

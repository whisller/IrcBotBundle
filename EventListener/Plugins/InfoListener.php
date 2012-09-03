<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins;

use Whisnet\IrcBotBundle\EventListener\Plugins\BaseListener;

use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;
use Whisnet\IrcBotBundle\IrcCommands\PrivMsgCommand;
use Whisnet\IrcBotBundle\Message\Message;

/**
 * Get information about bot.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class InfoListener extends BaseListener
{
    /**
     * @param BotCommandFoundEvent $event
     * @throws CommandException
     * @return boolean
     */
    public function onCommand(BotCommandFoundEvent $event)
    {
        $msg = 'Hi! My name is IrcBotBundle, you can find me on github (https://github.com/whisller/IrcBotBundle).';

        $privMsgCommand = new PrivMsgCommand($this->validator);
        $privMsgCommand->addReceiver($event->getChannel())->setText((string)new Message($msg));

        $event->getConnection()->sendData((string)$privMsgCommand);
    }
}

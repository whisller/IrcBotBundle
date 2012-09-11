<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins;

use Whisnet\IrcBotBundle\EventListener\Plugins\Interfaces\PluginInterface;
use Whisnet\IrcBotBundle\Event\BaseIrcEvent;
use Whisnet\IrcBotBundle\IrcCommands\PrivMsgCommand;
use Whisnet\IrcBotBundle\Message\Message;


/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
abstract class BasePluginListener implements PluginInterface
{
    /**
     * @param BaseIrcEvent $event
     * @param array $receivers
     * @param string $msg
     */
    protected function sendMessage(BaseIrcEvent $event, array $receivers, $msg)
    {
        $event->getConnection()->sendCommand(new PrivMsgCommand($receivers,
                                                                new Message($msg)));
    }
}

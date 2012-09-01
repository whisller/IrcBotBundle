<?php
namespace Whisnet\IrcBotBundle\EventListener;

use Whisnet\IrcBotBundle\EventListener\BaseListener;

class PingListener extends BaseListener
{
    public function getCommandName()
    {
        return 'PING';
    }

    public function executeCommand($event)
    {
        $arguments = $event->getArguments();

        $event->getIrc()->sendMessageToCurrentChannel('PONG '.$arguments[0]);
    }
}

<?php
namespace Whisnet\IrcBotBundle\EventListener;

use Whisnet\IrcBotBundle\Event\CommandEvent;

abstract class BaseListener
{
    public function onCommand(CommandEvent $event)
    {
        if ($event->getCommand() === $this->getCommandName()) {
            $this->executeCommand($event);
        }
    }

    abstract public function getCommandName();
    abstract public function executeCommand($event);
}

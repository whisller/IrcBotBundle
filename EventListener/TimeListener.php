<?php
namespace Whisnet\IrcBotBundle\EventListener;

use Whisnet\IrcBotBundle\EventListener\BaseListener;

class TimeListener extends BaseListener
{
    public function getCommandName()
    {
        return 'time';
    }

    public function executeCommand($event)
    {
        $dateTime = new \DateTime('now', new \DateTimeZone(date_default_timezone_get()));

        $event->getIrc()->sendMessageToCurrentChannel($dateTime->format('Y-m-d H:i:s'));
    }
}

<?php
namespace Whisnet\IrcBotBundle\EventListener;

use Whisnet\IrcBotBundle\EventListener\BaseListener;

class DateTimeListener extends BaseListener
{
    public function getCommandName()
    {
        return 'time';
    }

    public function executeCommand($event)
    {
        $arguments = $event->getArguments();

        $timezone = date_default_timezone_get();

        if (isset($arguments[0])) {
            if (in_array($arguments[0], \DateTimeZone::listIdentifiers())) {
                $timezone = $arguments[0];
            }
        }

        $dateTime = new \DateTime('now', new \DateTimeZone($timezone));

        $event->getIrc()->sendMessageToCurrentChannel($dateTime->format('Y-m-d H:i:s'));
    }
}

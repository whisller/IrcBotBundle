<?php
namespace Whisnet\IrcBotBundle\EventListener;

use Whisnet\IrcBotBundle\EventListener\BaseListener;

use Whisnet\IrcBotBundle\Commands\PrivMsgCommand;
use Whisnet\IrcBotBundle\Message\Message;

class DateTimeListener extends BaseListener
{
    public function onCommand($event)
    {
        $arguments = $event->getArguments();

        $timezone = date_default_timezone_get();

        if (isset($arguments[0])) {
            if (in_array($arguments[0], \DateTimeZone::listIdentifiers())) {
                $timezone = $arguments[0];
            }
        }

        $dateTime = new \DateTime('now', new \DateTimeZone($timezone));

        $msg = (string)new PrivMsgCommand(array('receiver' => $event->getChannel(),
                                                'text' => (string)new Message($dateTime->format('Y-m-d H:i:s'))));

        $event->getConnection()->sendData($msg);
    }
}

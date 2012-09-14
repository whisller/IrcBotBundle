<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins\Commands;

use Whisnet\IrcBotBundle\EventListener\Plugins\Commands\CommandListener;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;

/**
 * Retrieve information about date/time.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class DateTimeCommandListener extends CommandListener
{
    /**
     * {@inheritdoc}
     */
    public function onCommand(BotCommandFoundEvent $event)
    {
        $arguments = $event->getArguments();

        $timezone = date_default_timezone_get();

        if (isset($arguments[0]) && ('' !== trim($arguments[0]))) {
            if (in_array($arguments[0], \DateTimeZone::listIdentifiers())) {
                $timezone = $arguments[0];
            }
        }

        $dateTime = new \DateTime('now', new \DateTimeZone($timezone));

        $this->sendMessage(array($event->getChannel()), $dateTime->format('Y-m-d H:i:s'));
    }
}

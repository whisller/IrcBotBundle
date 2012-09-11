<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins;

use Whisnet\IrcBotBundle\EventListener\Plugins\BasePluginListener;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;
use Whisnet\IrcBotBundle\Annotations as ircbot;

/**
 * Retrieve information about date/time.
 *
 * @ircbot\CommandInfo(name="time", help="Display time in format Y-m-d H:i:s", arguments={"[ <timezone> ]"})
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class DateTimeListener extends BasePluginListener
{
    /**
     * @param BotCommandFoundEvent $event
     * @throws CommandException
     * @return boolean
     */
    public function onCommand(BotCommandFoundEvent $event)
    {
        $arguments = $event->getArguments();

        $timezone = date_default_timezone_get();

        if (isset($arguments[0]) && ('' !== trim($arguments[0]))) {
            if (in_array($arguments[0], \DateTimeZone::listIdentifiers())) {
                $timezone = $arguments[0];
            } else {
                $this->sendMessage($event, array($event->getChannel()), $event->getNickname().' I\'ve seen '.$arguments[0].' at '.$seen);

                return false;
            }
        }

        $dateTime = new \DateTime('now', new \DateTimeZone($timezone));

        $this->sendMessage($event, array($event->getChannel()), $dateTime->format('Y-m-d H:i:s'));
    }
}

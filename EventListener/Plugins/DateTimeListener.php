<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins;

use Whisnet\IrcBotBundle\EventListener\Plugins\BaseListener;

use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;
use Whisnet\IrcBotBundle\IrcCommands\PrivMsgCommand;
use Whisnet\IrcBotBundle\Message\Message;

/**
 * Retrieve information about date/time.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class DateTimeListener extends BaseListener
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
                $event->getConnection()->sendData((string)new PrivMsgCommand(array('receiver' => $event->getChannel(),
                                                                                   'text' => (string)new Message(sprintf('Sorry, I don\'t know about %s timezone.', $arguments[0])))));

                return false;
            }
        }

        $dateTime = new \DateTime('now', new \DateTimeZone($timezone));

        $privMsgCommand = new PrivMsgCommand($this->validator);
        $privMsgCommand->addReceiver($event->getChannel())->setText((string)new Message($dateTime->format('Y-m-d H:i:s')));

        $event->getConnection()->sendData((string)$privMsgCommand);
    }
}

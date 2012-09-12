<?php
namespace Whisnet\IrcBotBundle\EventListener\Irc;

use Whisnet\IrcBotBundle\EventListener\Irc\BaseIrcListener;
use Whisnet\IrcBotBundle\Event\DataFromServerEvent;
use Whisnet\IrcBotBundle\Event\IrcCommandFoundEvent;
use Whisnet\IrcBotBundle\IrcCommands\TimeCommand;

/**
 * Base listener for parse data from IRC server and execute proper event.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class ServerRequestListener extends BaseIrcListener
{
    /**
     * @param DataFromServerEvent $event
     */
    public function onData(DataFromServerEvent $event)
    {
        if ('' === $event->getData()) {
            $this->processEmptyData($event);
        } else {
            $this->processStringData($event);
        }
    }

    /**
     * Process empty response from server.
     *
     * Response is empty because we're using preg_replace on it, normally it is "false" response.
     *
     * @param DataFromServerEvent $event
     */
    private function processEmptyData(DataFromServerEvent $event)
    {
        $this->connection->sendCommand(new TimeCommand());
    }

    /**
     *  Process string response from server.
     *
     * @param DataFromServerEvent $event
     */
    private function processStringData(DataFromServerEvent $event)
    {
        $regex = "/^(?:[:@]([^\\s]+) )?([^\\s]+)(?: ((?:[^:\\s][^\\s]* ?)*))?(?: ?:(.*))?$/"; // @author Joshua Lückers (http://joshualuckers.nl/2010/01/10/regular-expression-to-match-raw-irc-messages/)
        preg_match($regex, $event->getData(), $matches);

        if (isset($matches[2]) && ('' !== trim($matches[2]))) {
            $this->dispatcher->dispatch('whisnet_irc_bot.irc_command_'.$matches[2], new IrcCommandFoundEvent($matches));
        }
    }
}

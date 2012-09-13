<?php
namespace Whisnet\IrcBotBundle\EventListener\Irc\Messages;

use Whisnet\IrcBotBundle\Connection\ConnectionInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Whisnet\IrcBotBundle\EventListener\Irc\BaseIrcListener;
use Whisnet\IrcBotBundle\Event\BaseIrcEvent;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class PrivMsgListener extends BaseIrcListener
{
    /**
     * @var string
     */
    private $botCommandPrefix;

    /**
     * @param ConnectionInterface $dispatcher
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(ConnectionInterface $connection, EventDispatcherInterface $dispatcher, $botCommandPrefix)
    {
        parent::__construct($connection, $dispatcher);

        $this->botCommandPrefix = $botCommandPrefix;
    }

    /**
     * @param BaseIrcEvent $event
     */
    public function onData(BaseIrcEvent $event)
    {
        $data = $event->getData();

        $isBotCommand = $this->isBotCommand($data[4]);

        if (is_array($isBotCommand) && (0 < count($isBotCommand))) {
            $matches = preg_split('/ /', $isBotCommand[1]);

            $command = $matches[0];
            $arguments = array_slice($matches, 1);

            $this->dispatcher->dispatch('whisnet_irc_bot.bot_command_'.$command, new BotCommandFoundEvent($data, $data[3], $arguments));
        }
    }

    /**
     * Check if message from server has a bot command.
     *
     * @param string $message
     * @return array if is bot command false otherwise
     */
    private function isBotCommand($message)
    {
        preg_match('/^'.$this->botCommandPrefix.' (.*)/', $message, $matches);

        return $matches;
    }
}
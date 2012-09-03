<?php
namespace Whisnet\IrcBotBundle\EventListener\Irc\Messages;

use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcherInterface;

use Whisnet\IrcBotBundle\Event\DataArrayFromServerEvent;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class PrivMsgListener
{
    /**
     * @var TraceableEventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @param TraceableEventDispatcherInterface $dispatcher
     */
    public function __construct(TraceableEventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param DataArrayFromServerEvent $event
     */
    public function onData(DataArrayFromServerEvent $event)
    {
        $data = $event->getData();

        $isBotCommand = $this->isBotCommand($data[4]);

        if (is_array($isBotCommand) && (0 < count($isBotCommand))) {
            $matches = preg_split('/ /', $isBotCommand[1]);

            $command = $matches[0];
            $arguments = array_slice($matches, 1);

            $botCommandFoundEvent = new BotCommandFoundEvent();
            $botCommandFoundEvent->setChannel($data[3])->setArguments($arguments)->setConnection($event->getConnection());

            $this->dispatcher->dispatch('whisnet_irc_bot.bot_command_'.$command, $botCommandFoundEvent);
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
        preg_match('/^!bot (.*)/', $message, $matches);

        return $matches;
    }
}
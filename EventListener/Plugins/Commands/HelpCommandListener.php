<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins\Commands;

use Whisnet\IrcBotBundle\EventListener\Plugins\Commands\CommandListener;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;

/**
 * Display help for bot.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class HelpCommandListener extends CommandListener
{
    /**
     * @var string
     */
    private $commandPrefix;

    /**
     * @var \SplDoublyLinkedList
     */
    private $commandsHolder;

    /**
     * @param string               $commandPrefix
     * @param \SplDoublyLinkedList $commandsHolder
     */
    public function setConfig($commandPrefix, \SplDoublyLinkedList $commandsHolder)
    {
        $this->commandPrefix = $commandPrefix;
        $this->commandsHolder = $commandsHolder;
    }

    /**
     * {@inheritdoc}
     */
    public function onCommand(BotCommandFoundEvent $event)
    {
        $this->sendMessage(array($event->getNickname()), 'IrcBotBundle (https://github.com/whisller/IrcBotBundle)');
        $this->sendMessage(array($event->getNickname()), 'Available commands:');

        $this->commandsHolder->rewind();
        while ($this->commandsHolder->valid()) {
            $current = $this->commandsHolder->current();

            if (isset($current[0]['command'])) {
                $msg = $this->commandPrefix.' '.$current[0]['command'].(isset($current[0]['arguments'])? ' '.$current[0]['arguments'] : '').(isset($current[0]['help']) ? ' : '.$current[0]['help']:'');
                $this->sendMessage(array($event->getNickname()), $msg);
            }

            $this->commandsHolder->next();
        }
    }
}

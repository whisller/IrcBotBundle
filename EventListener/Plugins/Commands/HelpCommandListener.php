<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins\Commands;

use Whisnet\IrcBotBundle\EventListener\Plugins\Commands\CommandListener;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;
use Whisnet\IrcBotBundle\Annotations as ircbot;
use Whisnet\IrcBotBundle\Utils\Help;

/**
 * Display help for bot.
 *
 * @ircbot\CommandInfo(name="help", help="Display this help")
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class HelpCommandListener extends CommandListener
{
    /**
     * @var Help
     */
    private $help;

    /**
     * @var string
     */
    private $commandPrefix;

    /**
     * @param Help $help
     */
    public function __construct(Help $help, $commandPrefix)
    {
        $this->help = $help;
        $this->commandPrefix = $commandPrefix;
    }

    /**
     * @param BotCommandFoundEvent $event
     * @throws CommandException
     * @return boolean
     */
    public function onCommand(BotCommandFoundEvent $event)
    {
        $this->sendMessage($event, array($event->getNickname()), 'IrcBotBundle (https://github.com/whisller/IrcBotBundle)');
        $this->sendMessage($event, array($event->getNickname()), 'Available commands:');

        foreach ($this->help->getAll() as $command => $args) {
            $msg = $this->commandPrefix.' '.$command.(isset($args[1])? ' '.implode($args[1]) : '').(isset($args[0]) ? ' : '.$args[0]:'');

            $this->sendMessage($event, array($event->getNickname()), $msg);
        }
    }
}

<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins\Commands\Interfaces;

use Whisnet\IrcBotBundle\Connection\ConnectionInterface;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;

/**
 * Interface for bot's commands.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
interface CommandInterface
{
    /**
     * @param  ConnectionInterface $connection
     * @return void
     */
    public function __construct(ConnectionInterface $connection);

    /**
     * @param  BotCommandFoundEvent $event
     * @throws CommandException     If validation of command do not pass
     * @return void
     */
    public function onCommand(BotCommandFoundEvent $event);
}

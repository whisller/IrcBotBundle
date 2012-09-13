<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins\Commands\Interfaces;

use Whisnet\IrcBotBundle\Connection\ConnectionInterface;

/**
 * Interface for bot's commands.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
interface CommandInterface
{
    /**
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection);
}

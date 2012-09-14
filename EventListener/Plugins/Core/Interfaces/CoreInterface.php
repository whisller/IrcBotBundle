<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins\Core\Interfaces;

use Whisnet\IrcBotBundle\Connection\ConnectionInterface;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
interface CoreInterface
{
    /**
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection);
}
<?php
namespace Whisnet\IrcBotBundle\EventListener\Irc;

use Whisnet\IrcBotBundle\Connection\ConnectionInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class BaseIrcListener
{
    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @param ConnectionInterface $connection
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(ConnectionInterface $connection, EventDispatcherInterface $dispatcher)
    {
        $this->connection = $connection;
        $this->dispatcher = $dispatcher;
    }
}
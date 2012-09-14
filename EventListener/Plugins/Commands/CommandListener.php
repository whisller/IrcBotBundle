<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins\Commands;

use Whisnet\IrcBotBundle\EventListener\Plugins\Commands\Interfaces\CommandInterface;
use Whisnet\IrcBotBundle\Connection\ConnectionInterface;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;
use Whisnet\IrcBotBundle\IrcCommands\PrivMsgCommand;
use Whisnet\IrcBotBundle\Message\Message;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
abstract class CommandListener implements CommandInterface
{
    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * {@inheritdoc}
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param array $receivers
     * @param string $msg
     */
    protected function sendMessage(array $receivers, $msg)
    {
        $this->connection->sendCommand(new PrivMsgCommand($receivers,
                                       new Message($msg)));
    }

    /**
     * {@inheritdoc}
     */
    abstract public function onCommand(BotCommandFoundEvent $event);
}

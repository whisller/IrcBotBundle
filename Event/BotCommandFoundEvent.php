<?php
namespace Whisnet\IrcBotBundle\Event;

use Whisnet\IrcBotBundle\Connection\ConnectionInterface;
use Whisnet\IrcBotBundle\Event\BaseIrcEvent;

/**
 * Bundle dispatch this event when find bot command.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class BotCommandFoundEvent extends BaseIrcEvent
{
    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var array
     */
    private $arguments = array();

    /**
     * @var string
     */
    private $channel;

    /**
     * @param array $data
     * @param ConnectionInterface $connection
     * @param string $channel
     * @param array $arguments
     */
    public function __construct(array $data, ConnectionInterface $connection, $channel, array $arguments)
    {
        parent::__construct($data);

        $this->connection = $connection;
        $this->channel = $channel;
        $this->arguments = $arguments;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }
}

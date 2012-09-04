<?php
namespace Whisnet\IrcBotBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use Whisnet\IrcBotBundle\Connection\Socket;

/**
 * Bundle dispatch this event when find bot command.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class BotCommandFoundEvent extends Event
{
    /**
     * @var array
     */
    private $arguments = array();

    /**
     * @var Socket
     */
    private $connection;

    /**
     * @var string
     */
    private $channel;

    /**
     * @var string
     */
    private $nickname;

    /**
     * @param array $arguments
     * @return BotCommandFoundEvent
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param Socket $connection
     * @return BotCommandFoundEvent
     */
    public function setConnection(Socket $connection)
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * @return Socket
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     *
     * @param string $channel
     * @return BotCommandFoundEvent
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param string $msg
     * @return BotCommandFoundEvent
     */
    public function setNicknameFromString($msg)
    {
        $regex = '/(?<=[^a-z_\-\[\]\\^{}|`])[a-z_\-\[\]\\^{}|`][a-z0-9_\-\[\]\\^{}|`]*/i'; // http://stackoverflow.com/a/5163309

        if (preg_match($regex, $msg, $matches)) {
            if (isset($matches[0])) {
                $this->nickname = $matches[0];
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }
}

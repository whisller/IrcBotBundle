<?php
namespace Whisnet\IrcBotBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use Whisnet\IrcBotBundle\Connection\Socket;

class BaseIrcEvent extends Event
{
    /**
     * @var string
     */
    private $nickname;

    /**
     * @var mixed
     */
    private $data;

    /**
     * @var Socket
     */
    private $connection;

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
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $msg
     * @return BotCommandFoundEvent
     */
    public function setNicknameFromString($msg)
    {
        $this->nickname = $this->getNicknameFromString($msg);

        return $this;
    }

    /**
     * @param string $msg
     */
    public function getNicknameFromString($msg)
    {
        $result = '';

        $regex = '/(?<=[^a-z_\-\[\]\\^{}|`])[a-z_\-\[\]\\^{}|`][a-z0-9_\-\[\]\\^{}|`]*/i'; // http://stackoverflow.com/a/5163309

        if (preg_match($regex, $msg, $matches)) {
            if (isset($matches[0])) {
                $result = $matches[0];
            }
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }
}
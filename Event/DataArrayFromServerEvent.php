<?php
namespace Whisnet\IrcBotBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use Whisnet\IrcBotBundle\Connection\Socket;

/**
 * Event used as a element of chain to notify about specified command notified from server.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class DataArrayFromServerEvent extends Event
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var Socket
     */
    private $connection;

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param Socket $connection
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
}

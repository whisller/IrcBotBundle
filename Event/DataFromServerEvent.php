<?php
namespace Whisnet\IrcBotBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Event used to notify about new data from server.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class DataFromServerEvent extends Event
{
    /**
     * @var string
     */
    private $data;

    /**
     * @param string $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }
}

<?php
namespace Whisnet\IrcBotBundle\Event;

use Whisnet\IrcBotBundle\Event\BaseIrcEvent;

/**
 * Event used to notify about new data from server.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class DataFromServerEvent extends BaseIrcEvent
{

    public function __construct($response, $connection) {
        $this->setData($response);
        $this->setConnection($connection);
    }

}

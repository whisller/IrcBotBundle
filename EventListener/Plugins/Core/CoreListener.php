<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins\Core;

use Whisnet\IrcBotBundle\Connection\ConnectionInterface;
use Whisnet\IrcBotBundle\EventListener\Plugins\Core\Interfaces\CoreInterface;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
abstract class CoreListener implements CoreInterface
{
    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }
}

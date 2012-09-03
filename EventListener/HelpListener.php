<?php
namespace Whisnet\IrcBotBundle\EventListener;

use Whisnet\IrcBotBundle\EventListener\BaseListener;

use Whisnet\IrcBotBundle\Commands\PrivMsgCommand;
use Whisnet\IrcBotBundle\Message\Message;

class HelpListener extends BaseListener
{
    private $dispatcher;

    public function __construct($dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function onCommand($event)
    {
    }
}

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
        $msg = (string)new PrivMsgCommand(array('receiver' => $event->getChannel(),
                                                'text' => (string)new Message('HELP is not available ;)')));

        $event->getConnection()->sendData($msg);
    }
}

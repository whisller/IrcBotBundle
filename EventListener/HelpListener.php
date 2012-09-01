<?php
namespace Whisnet\IrcBotBundle\EventListener;

use Whisnet\IrcBotBundle\EventListener\BaseListener;

class HelpListener extends BaseListener
{
    private $dispatcher;

    public function __construct($dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function getCommandName()
    {
        return 'help';
    }

    public function executeCommand($event)
    {
        var_dump($this->dispatcher->getListeners('whisnet_irc_bot.command'));
    }
}

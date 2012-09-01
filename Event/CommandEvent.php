<?php
namespace Whisnet\IrcBotBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class CommandEvent extends Event
{
    private $command = '';
    private $arguments = array();
    private $connection;
    private $channel = '';
    private $irc;

    public function setCommand($command)
    {
        $this->command = $command;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    public function setIrc($irc)
    {
        $this->irc = $irc;
    }

    public function getIrc()
    {
        return $this->irc;
    }
}

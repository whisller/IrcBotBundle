<?php
namespace Whisnet\IrcBotBundle\Commands;

class TimeCommand extends Command
{
    public function getName()
    {
        return 'TIME';
    }

    public function validate()
    {
        return true;
    }

    protected function getArguments()
    {
        return isset($this->args['server']) ? $this->args['server'] : '';
    }
}

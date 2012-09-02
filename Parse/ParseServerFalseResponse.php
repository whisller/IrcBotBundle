<?php
namespace Whisnet\IrcBotBundle\Parse;

use Whisnet\IrcBotBundle\Commands\TimeCommand;

class ParseServerFalseResponse extends Parse
{
    public function parse($data)
    {
        if (false === $data) {
            $this->arguments['connection']->sendData((string)new TimeCommand());
        }
    }
}

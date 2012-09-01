<?php
namespace Whisnet\IrcBotBundle\Parse;

class ParseCommand
{
    private $channel = '';
    private $command = '';
    private $arguments = array();
    private $isCommand = false;

    public function parse($prefix, $data)
    {
        $regex = '/PRIVMSG ([#&][^\x07\x2C\s]{0,200}) :'.$prefix.' (.*)/';

        if (preg_match($regex, $data, $matches)) {
            if (isset($matches[2])) {
                $patterns = array();
                $patterns[0] = "/\r\n/";
                $patterns[1] = "/\r/";

                $replacemenents = array();
                $replacemenents[0] = '';
                $replacemenents[1] = '';

                $args = preg_split('/ /', preg_replace($patterns, $replacemenents, $matches[2]));

                if (is_array($args)) {
                    $this->channel = $matches[1];
                    $this->command = $args[0];
                    $this->arguments = array_slice($args, 1);

                    $this->isCommand = true;
                }
            }
        }
    }

    public function getChannel()
    {
        return $this->channel;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    public function isCommand()
    {
        return $this->isCommand;
    }
}

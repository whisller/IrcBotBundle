<?php
namespace Whisnet\IrcBotBundle\Parse;

use Whisnet\IrcBotBundle\Event\CommandFoundEvent;

class ParseBotCommand extends Parse
{
    public function parse($data)
    {
        $regex = '/PRIVMSG ([#&][^\x07\x2C\s]{0,200}) :'.$this->arguments['prefix'].' (.*)/';

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
                    $channel = $matches[1];
                    $command = $args[0];
                    $commandArguments = array_slice($args, 1);

                    $event = new CommandFoundEvent();
                    $event->setConnection($this->arguments['connection']);
                    $event->setChannel($channel);
                    $event->setArguments($commandArguments);

                    $this->arguments['dispatcher']->dispatch('whisnet_irc_bot.command_'.$command, $event);
                }
            }
        } else {
            $this->successor->parse($data);
        }
    }
}

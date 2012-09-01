<?php
namespace Whisnet\IrcBotBundle\Commands;

class PrivMsgCommand extends Command
{
    protected function getName()
    {
        return 'PRIVMSG';
    }

    protected function validate()
    {
        if (!isset($this->args['receiver'])) {
            throw new CommandException('receiver: is required');
        }

        if (is_string($this->args['receiver'])) {
            if ('' === trim($this->args['receiver'])) {
                throw new CommandException('receiver: is required');
            } else {
                $this->args['receiver'] = array($this->args['receiver']);
            }
        }

        if (!isset($this->args['text'])) {
            throw new CommandException('text: is required');
        } elseif ('' === trim($this->args['text'])) {
            throw new CommandException('text: is required');
        }

        return true;
    }

    protected function getArguments()
    {
        return implode(',', $this->args['receiver']).' :'.$this->args['text'];
    }
}

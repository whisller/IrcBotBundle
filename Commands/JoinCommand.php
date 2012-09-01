<?php
namespace Whisnet\IrcBotBundle\Commands;


class JoinCommand extends Command
{
    protected function getName()
    {
        return 'JOIN';
    }

    protected function validate()
    {
        if (!isset($this->args['channel'])) {
            throw new CommandException('channel: is required');
        }

        if (is_string($this->args['channel'])) {
            if ('' === trim($this->args['channel'])) {
                throw new CommandException('channel: is required');
            } else {
                $this->args['channel'] = array($this->args['channel']);
            }
        }

        return true;
    }

    protected function getArguments()
    {
        return implode(',', $this->args['channel']);
    }
}

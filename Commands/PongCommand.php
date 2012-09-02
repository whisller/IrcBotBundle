<?php
namespace Whisnet\IrcBotBundle\Commands;

class PongCommand extends Command
{
    public function getName()
    {
        return 'PONG';
    }

    public function validate()
    {
        if (!isset($this->args['daemon'])) {
            throw new CommandException('daemon: is required');
        }

        if (is_string($this->args['daemon'])) {
            if ('' === trim($this->args['daemon'])) {
                throw new CommandException('daemon: is required');
            } else {
                $this->args['daemon'] = array($this->args['daemon']);
            }
        }

        return true;
    }

    protected function getArguments()
    {
        return implode(' ', $this->args['daemon']);
    }
}

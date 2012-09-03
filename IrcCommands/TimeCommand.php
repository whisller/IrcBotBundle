<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class TimeCommand extends Command
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'TIME';
    }

    /**
     * @return string
     */
    protected function getArguments()
    {
        return isset($this->args['server']) ? $this->args['server'] : '';
    }
}

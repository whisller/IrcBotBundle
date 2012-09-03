<?php
namespace Whisnet\IrcBotBundle\Commands;

use Symfony\Component\Validator\Constraints as Assert;

class JoinCommand extends Command
{
    private $channels = array();

    protected function getName()
    {
        return 'JOIN';
    }

    public function addChannel($channel)
    {
        if ('' !== trim($channel)) {
            $this->channels[] = $channel;
        }
    }

    protected function getArguments()
    {
        return implode(',', $this->channels);
    }
}

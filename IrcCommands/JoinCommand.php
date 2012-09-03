<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class JoinCommand extends Command
{
    /**
     * @NotBlank()
     */
    private $channels = array();

    /**
     * @return string
     */
    protected function getName()
    {
        return 'JOIN';
    }

    /**
     * @param string $channel
     * @return JoinCommand
     */
    public function addChannel($channel)
    {
        if ('' !== trim($channel)) {
            $this->channels[] = $channel;
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function getArguments()
    {
        return implode(',', $this->channels);
    }
}

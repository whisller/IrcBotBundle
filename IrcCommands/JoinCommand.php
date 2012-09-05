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
     * @param array $channels
     */
    public function __construct(array $channels)
    {
        foreach ($channels as $channel) {
            $this->addChannel($channel);
        }
    }

    /**
     * @param string $channel
     * @return JoinCommand
     */
    protected function addChannel($channel)
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

<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class PartCommand extends Command
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
        return 'PART';
    }

    public function __construct($channels) {
        if(is_array($channels)) {
            foreach($channels as $channel) {
                $this->addChannel($channel);
            }
        }
        else {
            $this->addChannel($channels);
        }
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

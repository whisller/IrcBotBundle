<?php
namespace Whisnet\IrcBotBundle\Event;

use Whisnet\IrcBotBundle\Event\BaseIrcEvent;

/**
 * Bundle dispatch this event when find bot command.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class BotCommandFoundEvent extends BaseIrcEvent
{
    /**
     * @var array
     */
    private $arguments = array();

    /**
     * @var string
     */
    private $channel;

    /**
     * @param array $arguments
     * @return BotCommandFoundEvent
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param string $channel
     * @return BotCommandFoundEvent
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }
}

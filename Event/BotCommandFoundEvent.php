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
     * @param array $data
     * @param string $channel
     * @param array $arguments
     */
    public function __construct(array $data, $channel, array $arguments)
    {
        parent::__construct($data);

        $this->channel = $channel;
        $this->arguments = $arguments;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }
}

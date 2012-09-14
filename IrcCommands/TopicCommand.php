<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * http://tools.ietf.org/html/rfc2812#section-3.2.4
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class TopicCommand extends Command
{
    /**
     * @var string
     * @NotBlank()
     */
    private $channel;

    /**
     * @var string|false
     */
    private $topic;

    /**
     * @return string
     */
    protected function getName()
    {
        return 'TOPIC';
    }

    /**
     * @param string $channel
     * @param string|false $topic
     */
    public function __construct($channel, $topic = false)
    {
        $this->setChannel($channel);
        $this->setTopic($topic);
    }

    /**
     * @param string $channel
     * @return TopicCommand
     */
    protected function setChannel($channel)
    {
        $this->channel = trim($channel);

        return $this;
    }

    /**
     * @param string|false $topic
     * @return TopicCommand
     */
    protected function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * @return string
     */
    protected function getArguments()
    {
        $result = $this->channel.(false !== $this->topic ? (' :'.$this->topic) : '');

        return $result;
    }
}

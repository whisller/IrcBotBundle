<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\Constraints\NotBlank;
use Whisnet\IrcBotBundle\Message\Message;

/**
 * http://tools.ietf.org/html/rfc2812#section-3.2.2
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class PartCommand extends Command
{
    /**
     * @var array
     * @NotBlank()
     */
    private $channels;

    /**
     * @var string
     */
    private $message;

    /**
     * @return string
     */
    protected function getName()
    {
        return 'PART';
    }

    /**
     * @param array $channels
     */
    public function __construct(array $channels, Message $message = null)
    {
        foreach ($channels as $channel) {
            $this->addChannel($channel);
        }

        $this->setMessage($message);
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
     * @param Message $message
     * @return PartCommand
     */
    protected function setMessage(Message $message = null)
    {
        if (null !== $message) {
            $this->message = trim((string)$message);
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function getArguments()
    {
        return implode(',', $this->channels).(null !== $this->message ? (' '.$this->message) : '');
    }
}

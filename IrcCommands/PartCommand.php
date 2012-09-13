<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\Constraints\NotBlank;

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
    public function __construct(array $channels, $message = '')
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
     * @param string $message
     */
    protected function setMessage($message)
    {
        $this->message = trim($message);
    }

    /**
     * @return string
     */
    protected function getArguments()
    {
        return implode(',', $this->channels).(0 < mb_strlen($this->message) ? (' '.$this->message) : '');
    }
}

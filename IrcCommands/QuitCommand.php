<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Whisnet\IrcBotBundle\Message\Message;

/**
 * http://tools.ietf.org/html/rfc2812#section-3.1.7
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class QuitCommand extends Command
{
    /**
     * @var string
     */
    private $message;

    /**
     * @return string
     */
    protected function getName()
    {
        return 'QUIT';
    }

    /**
     * @param Message $message
     */
    public function __construct(Message $message = null)
    {
        $this->setMessage($message);
    }

    /**
     * @param Message $message
     * @return QuitCommand
     */
    protected function setMessage(Message $message = null)
    {
        if (null !== $message) {
            $this->message = (string)$message;
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function getArguments()
    {
        return (isset($this->message) && ('' !== $this->message)) ? (':'.$this->message) : '';
    }
}

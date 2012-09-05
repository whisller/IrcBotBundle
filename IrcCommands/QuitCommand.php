<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

/**
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
     * @param string $message
     */
    public function __construct($message = '')
    {
        $this->setMessage($message);
    }

    /**
     * @param string $message
     * @return QuitCommand
     */
    protected function setMessage($message)
    {
        $this->message = $message;

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

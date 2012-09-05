<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\Constraints\NotBlank;

use Whisnet\IrcBotBundle\Message\Message;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class PrivMsgCommand extends Command
{
    /**
     * @NotBlank()
     */
    private $receiver;

    /**
     * @NotBlank()
     */
    private $text;

    /**
     * @return string
     */
    protected function getName()
    {
        return 'PRIVMSG';
    }

    /**
     * @param array $receivers
     * @param Message $text
     */
    public function __construct(array $receivers, Message $text)
    {
        foreach ($receivers as $receiver) {
            $this->addReceiver($receiver);
        }

        $this->setText($text);
    }

    /**
     * @param string $receiver
     * @return PrivMsgCommand
     */
    protected function addReceiver($receiver)
    {
        if ('' !== trim($receiver)) {
            $this->receiver[] = $receiver;
        }

        return $this;
    }

    /**
     * @param Message $text
     * @return PrivMsgCommand
     */
    protected function setText(Message $text)
    {
        $this->text = trim((string)$text);

        return $this;
    }

    /**
     * @return string
     */
    protected function getArguments()
    {
        return implode(',', $this->receiver).' :'.$this->text;
    }
}

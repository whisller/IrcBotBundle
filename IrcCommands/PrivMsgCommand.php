<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\Constraints\NotBlank;

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
     * @param string $receiver
     * @return PrivMsgCommand
     */
    public function addReceiver($receiver)
    {
        if ('' !== trim($receiver)) {
            $this->receiver[] = $receiver;
        }

        return $this;
    }

    /**
     * @param string $text
     * @return PrivMsgCommand
     */
    public function setText($text)
    {
        $this->text = trim($text);

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

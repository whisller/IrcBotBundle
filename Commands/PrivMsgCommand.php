<?php
namespace Whisnet\IrcBotBundle\Commands;

use Symfony\Component\Validator\Constraints\NotBlank;

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

    protected function getName()
    {
        return 'PRIVMSG';
    }

    public function addReceiver($receiver)
    {
        if ('' !== trim($receiver)) {
            $this->receiver[] = $receiver;
        }
    }

    public function setText($text)
    {
        $this->text = trim($text);
    }

    protected function getArguments()
    {
        return implode(',', $this->receiver).' :'.$this->text;
    }
}

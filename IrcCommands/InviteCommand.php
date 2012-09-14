<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * http://tools.ietf.org/html/rfc2812#section-3.2.7
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class InviteCommand extends Command
{
    /**
     * @var string
     * @NotBlank()
     */
    private $nickname;

    /**
     * @var string
     * @NotBlank()
     */
    private $channel;

    /**
     * @return string
     */
    public function getName()
    {
        return 'INVITE';
    }

    /**
     * @param string $nickname
     * @param string $channel
     */
    public function __construct($nickname, $channel)
    {
        $this->setNickname($nickname);
        $this->setChannel($channel);
    }

    /**
     * @param string $nickname
     * @return NickCommand
     */
    protected function setNickname($nickname)
    {
        $this->nickname = trim($nickname);

        return $this;
    }

    /**
     * @param string $channel
     * @return InviteCommand
     */
    protected function setChannel($channel)
    {
        $this->channel = trim($channel);

        return $this;
    }

    /**
     * @return string
     */
    protected function getArguments()
    {
        $result = $this->nickname.' '.$this->channel;

        return $result;
    }
}

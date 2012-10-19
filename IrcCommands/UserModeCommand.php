<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * http://tools.ietf.org/html/rfc2812#section-3.1.5
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class UserModeCommand extends Command
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
    private $mode;

    /**
     * @return string
     */
    public function getName()
    {
        return 'MODE';
    }

    /**
     * @param string $nickname
     * @param string $mode
     */
    public function __construct($nickname, $mode)
    {
        $this->setNickname($nickname);
        $this->setMode($mode);
    }

    /**
     * @param  string          $nickname
     * @return UserModeCommand
     */
    protected function setNickname($nickname)
    {
        $this->nickname = trim($nickname);

        return $this;
    }

    /**
     * @param  string          $mode
     * @return UserModeCommand
     */
    protected function setMode($mode)
    {
        $this->mode = trim($mode);

        return $this;
    }

    /**
     * @return string
     */
    protected function getArguments()
    {
        $result = $this->nickname.' '.$this->mode;

        return $result;
    }
}

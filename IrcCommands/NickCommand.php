<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * http://tools.ietf.org/html/rfc2812#section-3.1.2
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class NickCommand extends Command
{
    /**
     * @NotBlank()
     */
    private $nickname;

    /**
     * @return string
     */
    public function getName()
    {
        return 'NICK';
    }

    /**
     * @param string $nickname
     */
    public function __construct($nickname)
    {
        $this->setNickname($nickname);
    }

    /**
     * @param  string      $nickname
     * @return NickCommand
     */
    protected function setNickname($nickname)
    {
        $this->nickname = trim($nickname);

        return $this;
    }

    /**
     * @return string
     */
    protected function getArguments()
    {
        $result = $this->nickname;

        return $result;
    }
}

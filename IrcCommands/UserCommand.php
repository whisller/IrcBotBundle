<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * http://tools.ietf.org/html/rfc2812#section-3.1.3
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class UserCommand extends Command
{
    /**
     * @var string
     * @NotBlank()
     */
    private $username;

    /**
     * @var integer
     */
    private $mode;

    /**
     * @var string
     */
    private $realname;

    /**
     * @return string
     */
    protected function getName()
    {
        return 'USER';
    }

    public function __construct($username, $mode = 0, $realname = '')
    {
        $this->setUsername($username);
        $this->setMode($mode);
        $this->setRealname($realname);
    }

    /**
     * @param string $username
     * @return UserCommand
     */
    protected function setUsername($username)
    {
        $this->username = trim($username);

        return $this;
    }

    /**
     * @param integer $hostname
     * @return UserCommand
     */
    protected function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @param string $realname
     * @return UserCommand
     */
    protected function setRealname($realname)
    {
        $this->realname = trim($realname);

        return $this;
    }

    /**
     * @return string
     */
    protected function getArguments()
    {
        $result = '';

        $result = $this->username.' ';
        $result .= $this->mode.' ';
        $result .= ' * ';
        $result .= ':'.(!empty($this->realname) ? $this->realname : $this->username);

        return $result;
    }
}

<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class UserCommand extends Command
{
    /**
     * @NotBlank()
     */
    private $username;

    /**
     * @var string
     */
    private $hostname;

    /**
     * @var string
     */
    private $servername;

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

    /**
     * @param string $username
     * @return UserCommand
     */
    public function setUsername($username)
    {
        $this->username = trim($username);

        return $this;
    }

    /**
     * @param string $hostname
     * @return UserCommand
     */
    public function setHostname($hostname)
    {
        $this->hostname = trim($hostname);

        return $this;
    }

    /**
     * @param string $servername
     * @return UserCommand
     */
    public function setServername($servername)
    {
        $this->servername = trim($servername);

        return $this;
    }

    /**
     * @param string $realname
     * @return UserCommand
     */
    public function setRealname($realname)
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
        $result .= (isset($this->hostname) ? $this->hostname : 'example.com').' ';
        $result .= (isset($this->servername) ? $this->servername : $this->username).' ';
        $result .= ':'.(isset($this->realname) ? $this->realname : $this->username);

        return $result;
    }
}

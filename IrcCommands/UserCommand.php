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

    public function __construct($username, $hostname = '', $servername = '', $realname = '')
    {
        $this->setUsername($username);
        $this->setHostname($hostname);
        $this->setServername($servername);
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
     * @param string $hostname
     * @return UserCommand
     */
    protected function setHostname($hostname)
    {
        $this->hostname = trim($hostname);

        return $this;
    }

    /**
     * @param string $servername
     * @return UserCommand
     */
    protected function setServername($servername)
    {
        $this->servername = trim($servername);

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
        $result .= (!empty($this->hostname) ? $this->hostname : 'example.com').' ';
        $result .= (!empty($this->servername) ? $this->servername : $this->username).' ';
        $result .= ':'.(!empty($this->realname) ? $this->realname : $this->username);

        return $result;
    }
}

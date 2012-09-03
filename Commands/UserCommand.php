<?php
namespace Whisnet\IrcBotBundle\Commands;

use Symfony\Component\Validator\Constraints as Assert;

class UserCommand extends Command
{
    /**
     * @Assert\NotBlank()
     */
    private $username;
    private $hostname;
    private $servername;
    private $realname;

    protected function getName()
    {
        return 'USER';
    }

    public function setUsername($username)
    {
        $this->username = trim($username);
    }

    public function setHostname($hostname)
    {
        $this->hostname = trim($hostname);
    }

    public function setServername($servername)
    {
        $this->servername = trim($servername);
    }

    public function setRealname($realname)
    {
        $this->realname = trim($realname);
    }

    /**
     * @return string 
     */
    protected function getArguments()
    {
        $result = '';

        $result = $this->username.' ';
        $result .= isset($this->hostname) ? $this->hostname : 'example.com'.' ';
        $result .= isset($this->servername) ? $this->servername : $this->username.' ';
        $result .= ':'.(isset($this->realname) ? $this->realname : $this->username);

        return $result;
    }
}

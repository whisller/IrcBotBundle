<?php
namespace Whisnet\IrcBotBundle\IrcBot;

class Irc
{
    private $conn;
    private $user = array();
    private $joinChannel = '';

    public function __construct(array $user, $joinChannel)
    {
        $this->user = $user;
        $this->joinChannel = $joinChannel;
    }

    public function setConnection($conn)
    {
        $this->conn = $conn;
    }

    public function login()
    {
        $this->write('user', $this->user['username'].' '.$this->user['hostname'].' '.$this->user['servername'].' '.$this->user['realname']);
        $this->write('nick', $this->user['username']);
        $this->write('join', $this->joinChannel);
    }

    public function write($command, $message)
    {
        $this->conn->write($command.' '.$message."\r");
    }

    public function sendMessageToCurrentChannel($msg)
    {
        $this->write('PRIVMSG '.$this->joinChannel.' :', $msg);
    }

    public function __call($name, $arguments)
    {
        $this->write($name, implode(' ', $arguments));
    }
}

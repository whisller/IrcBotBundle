<?php
namespace Whisnet\IrcBotBundle\Commands;

class UserCommand extends Command
{
    protected function getName()
    {
        return 'USER';
    }

    public function validate()
    {
        if (!isset($this->args['username'])) {
            throw new CommandException('username: is required');
        } else {
            $this->args['username'] = trim($this->args['username']);

            if ('' === $this->args['username']) {
                throw new CommandException('username: is required');
            }
        }

        return true;
    }

    /**
     * @return string 
     */
    protected function getArguments()
    {
        $result = '';

        $result = $this->args['username'].' ';
        $result .= isset($this->args['hostname']) ? $this->args['hostname'] : 'example.com'.' ';
        $result .= isset($this->args['servername']) ? $this->args['servername'] : $this->args['username'].' ';
        $result .= ':'.(isset($this->args['realname']) ? $this->args['realname'] : $this->args['username']);

        return $result;
    }
}

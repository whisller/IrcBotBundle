<?php
namespace Whisnet\IrcBotBundle\Commands;

class NickCommand extends Command
{
    public function getName()
    {
        return 'NICK';
    }

    public function validate()
    {
        if (!isset($this->args['nickname'])) {
            throw new CommandException('nickname: is required');
        } else {
            $this->args['nickname'] = trim($this->args['nickname']);

            if ('' === $this->args['nickname']) {
                throw new CommandException('nickname: is required');
            }
        }
    }

   protected function getArguments()
   {
       $result = '';

       $result = $this->args['nickname'];

       return $result;
   }
}

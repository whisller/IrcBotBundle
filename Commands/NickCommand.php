<?php
namespace Whisnet\IrcBotBundle\Commands;

use Symfony\Component\Validator\Constraints\NotBlank;

class NickCommand extends Command
{
    /**
     * @NotBlank()
     */
    private $nickname;

    public function getName()
    {
        return 'NICK';
    }

    public function setNickname($nickname)
    {
        $this->nickname = trim($nickname);
    }

    protected function getArguments()
    {
        $result = '';

        $result = $this->nickname;

        return $result;
    }
}

<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class PongCommand extends Command
{
    /**
     * @NotBlank()
     */
    private $daemon;

    public function getName()
    {
        return 'PONG';
    }

    /**
     * @param string $daemon
     * @return PongCommand
     */
    public function addDaemon($daemon)
    {
        if ('' !== trim($daemon)) {
            $this->daemon[] = $daemon;
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function getArguments()
    {
        return implode(',', $this->daemon);
    }
}

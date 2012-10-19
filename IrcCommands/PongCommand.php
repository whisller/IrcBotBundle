<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * http://tools.ietf.org/html/rfc2812#section-3.7.3
 *
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
     * @param array $daemons
     */
    public function __construct(array $daemons)
    {
        foreach ($daemons as $daemon) {
            $this->addDaemon($daemon);
        }
    }

    /**
     * @param  string      $daemon
     * @return PongCommand
     */
    protected function addDaemon($daemon)
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
        return implode(' ', $this->daemon);
    }
}

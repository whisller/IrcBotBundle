<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

/**
 * http://tools.ietf.org/html/rfc2812#section-3.4.6
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class TimeCommand extends Command
{
    /**
     * @var target
     */
    private $target;

    /**
     * @return string
     */
    public function getName()
    {
        return 'TIME';
    }

    /**
     * @param string|null $target
     */
    public function __construct($target = null)
    {
        $this->setTarget($target);
    }

    /**
     * @param string|null $target
     */
    protected function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * @return string
     */
    protected function getArguments()
    {
        return null !== $this->target ? $this->target : '';
    }
}

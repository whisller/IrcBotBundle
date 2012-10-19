<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

/**
 * http://tools.ietf.org/html/rfc2812#section-3.2.6
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class ListCommand extends Command
{
    /**
     * @var array
     */
    private $channels;

    /**
     * @var string|false
     */
    private $target;

    /**
     * @return string
     */
    protected function getName()
    {
        return 'LIST';
    }

    /**
     * @param array   $channels
     * @param boolean $target
     */
    public function __construct(array $channels=array(), $target=false)
    {
        foreach ($channels as $channel) {
            $this->addChannel($channel);
        }

        $this->setTarget($target);
    }

    /**
     * @param  string      $channel
     * @return ListCommand
     */
    protected function addChannel($channel)
    {
        if ('' !== trim($channel)) {
            $this->channels[] = $channel;
        }

        return $this;
    }

    /**
     * @param string|false $target
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
        $result = 0 < count($this->channels) ? implode(',', $this->channels) : '';
        $result .= 0 < mb_strlen($this->target) ? (' '.$this->target) : '';

        return $result;
    }
}

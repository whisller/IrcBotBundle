<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * http://tools.ietf.org/html/rfc2812#section-3.2.3
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class ChannelModeCommand extends Command
{
    /**
     * @var string
     * @NotBlank()
     */
    private $channel;

    /**
     * @var string
     * @NotBlank()
     */
    private $mode;

    /**
     * @var string
     */
    private $modeParams;

    /**
     * @return string
     */
    public function getName()
    {
        return 'MODE';
    }

    /**
     * @param string $channel
     * @param string $mode
     * @param string $modeParams
     */
    public function __construct($channel, $mode, $modeParams = '')
    {
        $this->setChannel($channel);
        $this->setMode($mode);
        $this->setModeParams($modeParams);
    }

    /**
     * @param  string             $channel
     * @return ChannelModeCommand
     */
    protected function setChannel($channel)
    {
        $this->channel = trim($channel);

        return $this;
    }

    /**
     * @param  string             $mode
     * @return ChannelModeCommand
     */
    protected function setMode($mode)
    {
        $this->mode = trim($mode);

        return $this;
    }

    /**
     * @param  string             $modeParams
     * @return ChannelModeCommand
     */
    protected function setModeParams($modeParams)
    {
        $this->modeParams = trim($modeParams);

        return $this;
    }

    /**
     * @return string
     */
    protected function getArguments()
    {
        $result = $this->channel.' '.$this->mode.(0 < mb_strlen($this->modeParams) ? ' '.$this->modeParams : '');

        return $result;
    }
}

<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * http://tools.ietf.org/html/rfc2812#section-3.2.1
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class JoinCommand extends Command
{
    /**
     * @var array
     * @NotBlank()
     */
    private $channels;

    /**
     * @var array
     */
    private $keys;

    /**
     * @return string
     */
    protected function getName()
    {
        return 'JOIN';
    }

    /**
     * @param array $channels
     * @param array $keys
     */
    public function __construct(array $channels, array $keys = array())
    {
        foreach ($channels as $channel) {
            $this->addChannel($channel);
        }

        foreach ($keys as $key) {
            $this->addKey($key);
        }
    }

    /**
     * @param string $channel
     * @return JoinCommand
     */
    protected function addChannel($channel)
    {
        if ('' !== trim($channel)) {
            $this->channels[] = $channel;
        }

        return $this;
    }

    /**
     * @param string $key
     * @return JoinCommand
     */
    protected function addKey($key)
    {
        if ('' !== trim($key)) {
            $this->keys[] = $key;
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function getArguments()
    {
        $result = implode(',', $this->channels);
        $result .= 0 < count($this->keys) ? (' '.implode(',', $this->keys)) : '';

        return $result;
    }
}

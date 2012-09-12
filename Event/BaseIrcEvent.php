<?php
namespace Whisnet\IrcBotBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use Whisnet\IrcBotBundle\Connection\Socket;

class BaseIrcEvent extends Event
{
    /**
     * @var string
     */
    private $nickname;

    /**
     * @var mixed
     */
    private $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;

        if (isset($data[0])) {
            $this->setNicknameFromString($data[0]);
        }
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $msg
     */
    protected function setNicknameFromString($msg)
    {
        $regex = '/(?<=[^a-z_\-\[\]\\^{}|`])[a-z_\-\[\]\\^{}|`][a-z0-9_\-\[\]\\^{}|`]*/i'; // http://stackoverflow.com/a/5163309

        if (preg_match($regex, $msg, $matches)) {
            if (isset($matches[0])) {
                $this->nickname = $matches[0];
            }
        }
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }
}
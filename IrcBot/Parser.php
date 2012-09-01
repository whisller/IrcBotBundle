<?php
namespace Whisnet\IrcBotBundle\IrcBot;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Debug\ContainerAwareTraceableEventDispatcher;

use Whisnet\IrcBotBundle\Event\CommandEvent;

class Parser implements ParserInterface
{
    private $channel;
    private $commandPrefix;
    
    public function __construct($commandPrefix)
    {
        $this->commandPrefix = $commandPrefix;
    }

    public function parse($data, $conn)
    {
        $result = array();

        $regex = '/PRIVMSG #(.*) :'.$this->commandPrefix.' (.*)/';

        if (preg_match($regex, $data, $matches)) {
            if (isset($matches[2])) {
                $result = $this->getCommand($matches[2]);
            }
        } elseif (preg_match('/^PING (.*)/', $data, $matches)) {
            $result = array('ping', $this->cleanString($matches[1]));
        }

        return $result;
    }

    protected function cleanString($v)
    {
        $v = trim($v);

        $patterns = array();
        $patterns[0] = "/\r/";
        $patterns[1] = "/ {2,}/";

        $replacements = array();
        $replacements[0] = '';
        $replacements[1] = ' ';

        $v = preg_replace($patterns, $replacements, $v);

        return $v;
    }

    protected function getCommand($v)
    {
        $result = array();

        $result = preg_split('/[ ]/', $this->cleanString($v));

        return $result;
    }
}

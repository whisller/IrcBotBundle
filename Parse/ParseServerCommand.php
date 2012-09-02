<?php
namespace Whisnet\IrcBotBundle\Parse;

use Whisnet\IrcBotBundle\Commands;

class ParseServerCommand extends Parse
{
    private $handled = array(
        'PING' => 'processPing'
    );

    public function parse($data)
    {
        /**
         * @author Joshua Lückers (http://joshualuckers.nl/2010/01/10/regular-expression-to-match-raw-irc-messages/)
         */
        $regex = "/^(?:[:@]([^\\s]+) )?([^\\s]+)(?: ((?:[^:\\s][^\\s]* ?)*))?(?: ?:(.*))?$/";

        preg_match($regex, $data, $matches);

        if (isset($matches[2])) {
            $method = 'on'.$matches[2];

            if (false === $this->$method($matches)) {
                $this->successor->parse($data);
            }
        } else {
            $this->successor->parse($data);
        }
    }

    public function __call($name, $arguments)
    {
        $method = mb_substr($name, 2);
        if (isset($this->handled[$method])) {
            return call_user_func(array($this, $this->handled[$method]), $arguments);
        }

        return false;
    }

    /**
     * @param array $arguments
     */
    protected function processPing(array $arguments)
    {
        $this->arguments['connection']->sendData((string)new Commands\PongCommand(array('daemon' => $arguments[0][4])));
    }
}

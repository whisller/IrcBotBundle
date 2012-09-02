<?php
namespace Whisnet\IrcBotBundle\Parse;

class ParseServerCommand extends Parse
{
    public function parse($data)
    {
        /**
         * @author Joshua Lückers (http://joshualuckers.nl/2010/01/10/regular-expression-to-match-raw-irc-messages/)
         */
        $regex = "/^(?:[:@]([^\\s]+) )?([^\\s]+)(?: ((?:[^:\\s][^\\s]* ?)*))?(?: ?:(.*))?$/";

        preg_match($regex, $data, $matches);

        if (true) {
            $this->successor->parse($data);
        }
    }
}

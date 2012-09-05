<?php
/**
 * User: mike
 * Date: 05.09.2012
 * Time: 09:56
 */

namespace \Whisnet\IrcBotBundle\IrcCommands;

use \Whisnet\IrcBotBundle\IrcCommands\Interfaces\Response as ResponseInterface;

class Response implements ResponseInterface {

    protected $rawData;

    protected $clenData = null;

    public function __construct($rawdata) {
        $this->rawData = $rawdata;
    }

    public function getData() {
        if ($this->clenData == null) {
            $this->clenData = \Whisnet\IrcBotBundle\Utils\Utils::cleanUpServeRequest($this->rawData);
        }
        return $this->clenData;
    }

}
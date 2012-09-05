<?php

namespace Whisnet\IrcBotBundle\Connection;

use \Whisnet\IrcBotBundle\IrcCommands\Interfaces\Command;


    /**
     * IRC Bot
     *
     * LICENSE: This source file is subject to Creative Commons Attribution
     * 3.0 License that is available through the world-wide-web at the following URI:
     * http://creativecommons.org/licenses/by/3.0/.  Basically you are free to adapt
     * and use this script commercially/non-commercially. My only requirement is that
     * you keep this header as an attribution to my work. Enjoy!
     *
     * @license    http://creativecommons.org/licenses/by/3.0/
     *
     * @package IRCBot
     * @subpackage Library
     *
     * @encoding UTF-8
     * @created Jan 11, 2012 11:02:00 PM
     *
     * @author Daniel Siepmann <coding.layne@me.com>
     */

    /**
     * Delivers a connection via socket to the IRC server.
     *
     * @package IRCBot
     * @subpackage Library
     * @author Daniel Siepmann <Daniel.Siepmann@wfp2.com>
     */
    class Socket implements ConnectionInterface {

        /**
         * The server you want to connect to.
         * @var string
         */
        private $server = '';

        /**
         * The port of the server you want to connect to.
         * @var integer
         */
        private $port = 0;

        /**
         * The TCP/IP connection.
         * @var type
         */
        private $socket;

        private $validator;

        public function __construct($server = '127.0.0.1', $port = 321) {
            $this->setServer($server);
            $this->setPort($port);
        }

        /**
         * Close the connection.
         */
        public function __destruct() {
            $this->disconnect();
        }

        /**
         * Establishs the connection to the server.
         */
        public function connect() {
            $this->socket = stream_socket_client( $this->server.':'.$this->port, $errno, $errstr, ini_get("default_socket_timeout"), STREAM_CLIENT_CONNECT );
            if (!$this->isConnected()) {
                throw new Exception( 'Unable to connect to server via fsockopen with server: "' . $this->server . '" and port: "' . $this->port . '".' );
            }
        }

        /**
         * Disconnects from the server.
         *
         * @return boolean True if the connection was closed. False otherwise.
         */
        public function disconnect() {
            return stream_socket_shutdown( $this->socket, STREAM_SHUT_WR );
        }

        /**
         * Interaction with the server.
         * For example, send commands or some other data to the server.
         *
         * @return int|boolean the number of bytes written, or FALSE on error.
         */
        public function sendData( $data ) {
            return fwrite( $this->socket, $data );
        }

        public function sendCommand(Command $command) {
            $command->setValidator($this->validator);
            $command->validate();
            $this->sendData($command->asData());
        }

        /**
         * Returns data from the server.
         *
         * @return string|boolean The data as string, or false if no data is available or an error occured.
         */
        public function getData() {
            return fgets( $this->socket );
        }

        public function getResponse() {
            return new Response($this->getData());
        }

        public function setValidator(ValidatorInterface $validator) {
            $this->validator = $validator;
        }

        /**
         * Check wether the connection exists.
         *
         * @return boolean True if the connection exists. False otherwise.
         */
        public function isConnected() {
            if (is_resource( $this->socket )) {
                return true;
            }
            return false;
        }

        /**
         * Sets the server.
         * E.g. irc.quakenet.org or irc.freenode.org
         * @param string $server The server to set.
         * @return Socket
         */
        public function setServer( $server ) {
            $this->server = (string) $server;

            return $this;
        }

        /**
         * Sets the port.
         * E.g. 6667
         * @param integer $port The port to set.
         * @return Socket
         */
        public function setPort( $port ) {
            $this->port = (int) $port;

            return $this;
        }

    }

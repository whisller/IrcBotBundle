<?php
namespace Whisnet\IrcBotBundle\Connection;

use Symfony\Component\Validator\ValidatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Whisnet\IrcBotBundle\IrcCommands\Interfaces\CommandInterface;
use Whisnet\IrcBotBundle\Event\Connection\PostConnectionEvent;

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
class Socket implements ConnectionInterface
{
    
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

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * {@inheritdoc}
     */
    public function __construct($server, $port = 6667, ValidatorInterface $validator, EventDispatcherInterface $dispatcher)
    {
        $this->server = $server;
        $this->port = $port;
        $this->validator = $validator;
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function __destruct()
    {
        $this->disconnect();
    }

    /**
     * {@inheritdoc}
     */
    public function connect()
    {
        $this->socket = stream_socket_client($this->server.':'.$this->port);
        if (!$this->isConnected()) {
            throw new Exception('Unable to connect to server via fsockopen with server: "'.$this->server.'" and port: "'.$this->port.'".');
        }

        $this->dispatcher->dispatch('whisnet_irc_bot.post_connection', new PostConnectionEvent());
    }

    /**
     * {@inheritdoc}
     */
    public function disconnect()
    {
        return is_object($this->socket) ? stream_socket_shutdown($this->socket, STREAM_SHUT_WR) : false;
    }

    /**
     * {@inheritdoc}
     */
    public function sendData($data)
    {
        return fwrite($this->socket, $data);
    }

    /**
     * @param CommandInterface $command
     */
    public function sendCommand(CommandInterface $command)
    {
        $command->setValidator($this->validator);
        $command->validate();

        $this->sendData((string)$command);
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return fgets($this->socket);
    }

    /**
     * {@inheritdoc}
     */
    public function isConnected()
    {
        if (is_resource($this->socket)) {
            return true;
        }

        return false;
    }
}

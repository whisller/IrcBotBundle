<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins\Core;

use Whisnet\IrcBotBundle\Event\Connection\PostConnectionEvent;
use Whisnet\IrcBotBundle\IrcCommands\UserCommand;
use Whisnet\IrcBotBundle\IrcCommands\NickCommand;
use Whisnet\IrcBotBundle\IrcCommands\JoinCommand;
use Whisnet\IrcBotBundle\IrcCommands\PassCommand;

/**
 * Listener is used after connection to the server is established to setup basic information about user,
 * like username, its real name, join the channels specified in whisnet_irc_bot.channels parameter.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class LoadUserCoreListener extends CoreListener
{
    /**
     * @var array
     */
    private $user = array();

    /**
     * @var array
     */
    private $channels = array();

    /**
     * @param PostConnectionEvent $event
     */
    public function onCore(PostConnectionEvent $event)
    {
        if($this->user['password'] !== '')
        {
            $this->connection->sendCommand(new PassCommand($this->user['password']));
        }

        $this->connection->sendCommand(new UserCommand($this->user['username'], $this->user['mode'], $this->user['realname']));
        $this->connection->sendCommand(new NickCommand($this->user['username']));
        sleep(10); // allow the bot to connect and authenticate: this is a hack @todo: fix
        $this->connection->sendCommand(new JoinCommand($this->channels));
    }

    /**
     * @param array $user
     * @param array $channels
     */
    public function setConfig(array $user, array $channels)
    {
        $this->user = $user;
        $this->channels = $channels;
    }
}

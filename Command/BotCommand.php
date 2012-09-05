<?php
namespace Whisnet\IrcBotBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Whisnet\IrcBotBundle\Connection\Socket;
use Whisnet\IrcBotBundle\Event\DataFromServerEvent;
use Whisnet\IrcBotBundle\IrcCommands\UserCommand;
use Whisnet\IrcBotBundle\IrcCommands\NickCommand;
use Whisnet\IrcBotBundle\IrcCommands\JoinCommand;
use Whisnet\IrcBotBundle\IrcCommands\PrivMsgCommand;
use Whisnet\IrcBotBundle\Utils\Utils;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class BotCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ircbot:launch')
            ->setDescription('Launch the IrcBot!')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dispatcher = $this->getContainer()->get('event_dispatcher');

        $serverConfig = $this->getContainer()->getParameter('whisnet_irc_bot.server');
        $userConfig = $this->getContainer()->getParameter('whisnet_irc_bot.user');
        $channels = $this->getContainer()->getParameter('whisnet_irc_bot.channels');

        $socket = new Socket($serverConfig[0], $serverConfig[1]);
        $socket->connect();
        $socket->setValidator($this->getContainer()->get('validator'));


        $userCommand = new UserCommand($userConfig['username'], $userConfig['realname'], $userConfig['hostname'], $userConfig['servername']);
        $socket->sendCommand($userCommand);

        $nickCommand = new NickCommand($userConfig['username']);
        $socket->sendCommand($nickCommand);

        $joinCommand = new JoinCommand($channels);
        $socket->sendCommand($joinCommand);

        do {

            $data = $socket->getResponse();

            $event = new DataFromServerEvent($data, $socket);

            $dispatcher->dispatch('whisnet_irc_bot.data_from_server', $event);

        } while(true);
    }
}

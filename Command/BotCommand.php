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

        $socket = new Socket();
        $socket->setServer($serverConfig[0])
                ->setPort($serverConfig[1])
                ->connect();

        $validator = $this->getContainer()->get('validator');

        $userCommand = new UserCommand($validator);
        $userCommand->setUsername($userConfig['username'])
                ->setRealname($userConfig['realname'])
                ->setHostname($userConfig['hostname'])
                ->setServername($userConfig['servername'])
                ->validate();
        $socket->sendData((string)$userCommand);

        $nickCommand = new NickCommand($validator);
        $nickCommand->setNickname($userConfig['username'])
                ->validate();
        $socket->sendData((string)$nickCommand);

        $joinCommand = new JoinCommand($validator);
        foreach ($channels as $channel) {
            $joinCommand->addChannel($channel);
        }
        $joinCommand->validate();
        $socket->sendData((string)$joinCommand);

        do {
            $data = Utils::cleanUpServeRequest($socket->getData());

            var_dump($data);

            $event = new DataFromServerEvent();
            $event->setData($data)
                    ->setConnection($socket);

            $dispatcher->dispatch('whisnet_irc_bot.data_from_server', $event);
        } while(true);
    }
}

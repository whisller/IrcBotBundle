<?php
namespace Whisnet\IrcBotBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Whisnet\IrcBotBundle\Event\DataFromServerEvent;
use Whisnet\IrcBotBundle\IrcCommands\UserCommand;
use Whisnet\IrcBotBundle\IrcCommands\NickCommand;
use Whisnet\IrcBotBundle\IrcCommands\JoinCommand;
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

        $socket = $this->getContainer()->get('whisnet_irc_bot.connection');
        $socket->connect();

        $userConfig = $this->getContainer()->getParameter('whisnet_irc_bot.user');

        $socket->sendCommand(new UserCommand($userConfig['username'], $userConfig['hostname'], $userConfig['servername'], $userConfig['realname']));
        $socket->sendCommand(new NickCommand($userConfig['username']));
        $socket->sendCommand(new JoinCommand($this->getContainer()->getParameter('whisnet_irc_bot.channels')));

        do {
            $data = Utils::cleanUpServerRequest($socket->getData());

            var_dump($data);

            $dispatcher->dispatch('whisnet_irc_bot.data_from_server', new DataFromServerEvent($data));
        } while(true);
    }
}

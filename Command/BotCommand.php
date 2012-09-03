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

use Whisnet\IrcBotBundle\Message\Message;

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

        $socket = new Socket();
        $socket->setServer('irc.freenode.net');
        $socket->setPort('6667');
        $socket->connect();

        $validator = $this->getContainer()->get('validator');

        $userCommand = new UserCommand($validator);
        $userCommand->setUsername('IrcBotBundle');
        $userCommand->validate();
        $socket->sendData((string)$userCommand);

        $nickCommand = new NickCommand($validator);
        $nickCommand->setNickname('IrcBotBundle');
        $nickCommand->validate();
        $socket->sendData((string)$nickCommand);

        $joinCommand = new JoinCommand($validator);
        $joinCommand->addChannel('#test-irc');
        $joinCommand->validate();
        $socket->sendData((string)$joinCommand);

        $privMsgCommand = new PrivMsgCommand($validator);
        $privMsgCommand->addReceiver('#test-irc')->setText((string)new Message('Witam wszystkich!'));
        $privMsgCommand->validate();
        $socket->sendData((string)$privMsgCommand);

        do {
            $data = $socket->getData();
            $patterns[0] = "/\r/";
            $patterns[1] = "/\r\n/";
            $patterns[2] = "/\n/";
            $replacements[0] = '';
            $replacements[1] = '';
            $replacements[2] = '';
            $data = preg_replace($patterns, $replacements, $data);

            var_dump($data);

            $event = new DataFromServerEvent();
            $event->setData($data);
            $event->setConnection($socket);
            $dispatcher->dispatch('whisnet_irc_bot.data_from_server', $event);
        } while(true);
    }
}

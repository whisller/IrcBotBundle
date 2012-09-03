<?php
namespace Whisnet\IrcBotBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Whisnet\IrcBotBundle\Connection\Socket;

use Whisnet\IrcBotBundle\IrcBot\Parser;
use Whisnet\IrcBotBundle\IrcBot\Irc;

use Whisnet\IrcBotBundle\Commands\UserCommand;
use Whisnet\IrcBotBundle\Commands\NickCommand;
use Whisnet\IrcBotBundle\Commands\JoinCommand;
use Whisnet\IrcBotBundle\Commands\PrivMsgCommand;

use Whisnet\IrcBotBundle\Message\Message;

use Whisnet\IrcBotBundle\Parse\ParseBotCommand;
use Whisnet\IrcBotBundle\Parse\ParseServerCommand;
use Whisnet\IrcBotBundle\Parse\ParseServerFalseResponse;

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
        $privMsgCommand->addReceiver('#test-irc');
        $privMsgCommand->setText((string)new Message('Witam wszystkich!'));
        $socket->sendData((string)$privMsgCommand);

        do {
            $data = $socket->getData();
            var_dump($data);

            $parseServerCommand = new ParseServerCommand(array('connection' => $socket));
            $parseBotCommand = new ParseBotCommand(array('connection' => $socket,
                                                         'dispatcher' => $dispatcher,
                                                         'prefix' => '!bot'));
            $parseServerFalseResponse = new ParseServerFalseResponse(array('connection' => $socket));

            $parseServerCommand->setSuccessor($parseBotCommand);
            $parseBotCommand->setSuccessor($parseServerFalseResponse);

            $parseServerCommand->parse($data);
        } while(true);
    }
}

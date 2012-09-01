<?php
namespace Whisnet\IrcBotBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Whisnet\IrcBotBundle\Connection\Socket;

use Whisnet\IrcBotBundle\IrcBot\Parser;
use Whisnet\IrcBotBundle\Event\CommandFoundEvent;
use Whisnet\IrcBotBundle\IrcBot\Irc;

use Whisnet\IrcBotBundle\Commands\UserCommand;
use Whisnet\IrcBotBundle\Commands\NickCommand;
use Whisnet\IrcBotBundle\Commands\JoinCommand;
use Whisnet\IrcBotBundle\Commands\PrivMsgCommand;

use Whisnet\IrcBotBundle\Message\Message;

use Whisnet\IrcBotBundle\Parse\ParseCommand;

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

        $socket->sendData((string)new UserCommand(array('username' => 'IrcBotBundle')));
        $socket->sendData((string)new NickCommand(array('nickname' => 'IrcBotBundle')));
        $socket->sendData((string)new JoinCommand(array('channel' => '#test-irc')));
        $socket->sendData((string)new PrivMsgCommand(array('receiver' => array('#test-irc'),
                                                           'text' => (string)new Message('Witam wszystkich!'))));

        do {
            $data = $socket->getData();
            echo $data;

            $parse = new ParseCommand();
            $parse->parse('!bot', $data);

            if ($parse->isCommand()) {
                $event = new CommandFoundEvent();
                $event->setConnection($socket);
                $event->setChannel($parse->getChannel());
                $event->setArguments($parse->getArguments());

                $dispatcher->dispatch('whisnet_irc_bot.command_'.$parse->getCommand(), $event);
            }
        } while(true);
    }
}

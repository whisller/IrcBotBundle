<?php
namespace Whisnet\IrcBotBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use React\EventLoop;
use React\Socket;
use React\Stream;

use Whisnet\IrcBotBundle\IrcBot\Parser;
use Whisnet\IrcBotBundle\Event\CommandFoundEvent;
use Whisnet\IrcBotBundle\IrcBot\Irc;

use Whisnet\IrcBotBundle\Commands\UserCommand;
use Whisnet\IrcBotBundle\Commands\NickCommand;
use Whisnet\IrcBotBundle\Commands\JoinCommand;
use Whisnet\IrcBotBundle\Commands\PrivMsgCommand;
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

        $loop = EventLoop\Factory::create();

        $socket = new Socket\Connection(stream_socket_client('irc.freenode.net:6667'), $loop);
        $socket->pipe(new Stream\Stream(STDOUT, $loop));

        $socket->write((string)new UserCommand(array('username' => 'IrcBotBundle')));
        $socket->write((string)new NickCommand(array('nickname' => 'IrcBotBundle')));
        $socket->write((string)new JoinCommand(array('channel' => '#test-irc')));
        $socket->write((string)new PrivMsgCommand(array('receiver' => array('#test-irc'),
                                                        'text' => 'Witam wszystkich!')));

        $socket->on('data', function ($data) use ($socket, $dispatcher) {
            $parse = new ParseCommand();
            $parse->parse('!bot', $data);

            if ($parse->isCommand()) {
                $event = new CommandFoundEvent();
                $event->setConnection($socket);
                $event->setChannel($parse->getChannel());
                $event->setArguments($parse->getArguments());

                $dispatcher->dispatch('whisnet_irc_bot.command_'.$parse->getCommand(), $event);
            }
        });

        $loop->run();
    }
}

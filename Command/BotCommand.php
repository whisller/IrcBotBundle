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
use Whisnet\IrcBotBundle\Event\CommandEvent;
use Whisnet\IrcBotBundle\IrcBot\Irc;

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
        $loop = EventLoop\Factory::create();

        $server = $this->getContainer()->getParameter('whisnet_irc_bot.server');

        $socket = new Socket\Connection(stream_socket_client($server['host'].':'.$server['port']), $loop);
        $socket->pipe(new Stream\Stream(STDOUT, $loop));

        $parser = $this->getContainer()->get('whisnet_irc_bot.parser');
        $irc = $this->getContainer()->get('whisnet_irc_bot.irc');
        $irc->setConnection($socket);
        $irc->login();

        $dispatcher = $this->getContainer()->get('event_dispatcher');

        $socket->on('data', function ($data) use ($socket, $parser, $dispatcher, $irc) {
            $args = $parser->parse($data, $socket);

            if (0 < count($args)) {
                $event = new CommandEvent();
                $event->setCommand($args[0]);
                $event->setArguments(array_slice($args, 1));
                $event->setIrc($irc);

                $dispatcher->dispatch('whisnet_irc_bot.command', $event);
            }
        });

        $loop->run();
    }
}

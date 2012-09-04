<?php
namespace Whisnet\IrcBotBundle\EventListener\Irc\Messages;

use Symfony\Component\Validator\ValidatorInterface;

use Whisnet\IrcBotBundle\Event\DataArrayFromServerEvent;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;

use Whisnet\IrcBotBundle\IrcCommands\PongCommand;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */

class PingListener
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param DataArrayFromServerEvent $event
     */
    public function onData(DataArrayFromServerEvent $event)
    {
        $data = $event->getData();

        $pongCommand = new PongCommand($this->validator);
        $pongCommand->addDaemon($data[4])
                ->validate();

        $event->getConnection()->sendData((string)$pongCommand);
    }
}
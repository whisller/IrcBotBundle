<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins;

use Symfony\Component\Validator\ValidatorInterface;

use Whisnet\IrcBotBundle\EventListener\Plugins\BaseListener;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;
use Whisnet\IrcBotBundle\Event\DataArrayFromServerEvent;

use Whisnet\IrcBotBundle\IrcCommands\PrivMsgCommand;
use Whisnet\IrcBotBundle\Message\Message;

/**
 * Listener is adding "last seen" functionality.
 * It read and update information about last seen of user.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class SeenListener extends BaseListener
{
    /**
     * @var string
     */
    private $cacheFile;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator, $cacheDir)
    {
        $this->cacheFile = $cacheDir.DIRECTORY_SEPARATOR.'irc-bot-bundle-seen.php';

        parent::__construct($validator);
    }

    /**
     * @param BotCommandFoundEvent $event
     * @throws CommandException
     * @return boolean
     */
    public function onCommand(BotCommandFoundEvent $event)
    {
        $arguments = $event->getArguments();

        if (!isset($arguments[0])) {
            $this->noNickname($event);
        } else {
            if (file_exists($this->cacheFile)) {
                include $this->cacheFile;

                if (isset($seen[$arguments[0]])) {
                    $privMsgCommand = new PrivMsgCommand($this->validator);
                    $privMsgCommand->addReceiver($event->getChannel())
                            ->setText((string)new Message($event->getNickname().' I\'ve seen '.$arguments[0].' at '.$seen[$arguments[0]]))
                            ->validate();

                    $event->getConnection()->sendData((string)$privMsgCommand);
                } else {
                    $this->noInformationAvailable($event);
                }
            } else {
                $this->noInformationAvailable($event);
            }
        }
    }

    /**
     * @param DataArrayFromServerEvent $event
     * @throws CommandException
     * @return boolean
     */
    public function updateInformation(DataArrayFromServerEvent $event)
    {
        $data = $event->getData();

        if (file_exists($this->cacheFile)) {
            include $this->cacheFile;
        } else {
            $seen = array();
        }

        $dateTime = new \DateTime('now', new \DateTimeZone(date_default_timezone_get()));

        $seen[$event->getNicknameFromString($data[0])] = $dateTime->format('Y-m-d H:i:s');

        $handle = fopen($this->cacheFile, 'w');
        fwrite($handle, '<?php '."\n".'$seen = array(); $seen = '.var_export($seen, true).';');
        fclose($handle);
    }

    /**
     * @param BotCommandFoundEvent $event
     */
    private function noInformationAvailable(BotCommandFoundEvent $event)
    {
        $arguments = $event->getArguments();

        $privMsgCommand = new PrivMsgCommand($this->validator);
        $privMsgCommand->addReceiver($event->getChannel())
                ->setText((string)new Message('Sorry '.$event->getNickname().' I don\'t have information about '.$arguments[0]))
                ->validate();

        $event->getConnection()->sendData((string)$privMsgCommand);
    }

    /**
     * @param BotCommandFoundEvent $event
     */
    private function noNickname(BotCommandFoundEvent $event)
    {
        $privMsgCommand = new PrivMsgCommand($this->validator);
        $privMsgCommand->addReceiver($event->getChannel())
                ->setText((string)new Message($event->getNickname().' who are you looking for?'))
                ->validate();

        $event->getConnection()->sendData((string)$privMsgCommand);
    }
}

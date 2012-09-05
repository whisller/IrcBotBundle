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
            $seen = $this->readFromSeen($arguments[0]);
            if ($seen) {
                $privMsgCommand = new PrivMsgCommand($this->validator);
                $privMsgCommand->addReceiver($event->getChannel())
                        ->setText((string)new Message($event->getNickname().' I\'ve seen '.$arguments[0].' at '.$seen))
                        ->validate();

                $event->getConnection()->sendData((string)$privMsgCommand);
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

        $dateTime = new \DateTime('now', new \DateTimeZone(date_default_timezone_get()));

        $this->writeToSeen($event->getNicknameFromString($data[0]), $dateTime->format('Y-m-d H:i:s'));

        unset($dateTime);
        unset($data);
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

    /**
     * @param string $nickname
     * @param string $date
     */
    private function writeToSeen($nickname, $date)
    {
        $seenFile = file_exists($this->cacheFile) ? file_get_contents($this->cacheFile) : false;

        if (false !== $seenFile) {
            $seenArray = json_decode($seenFile, true);
   
            unset($seenFile);
        } else {
            $seenArray = array();
        }

        $seenArray[$nickname] = $date;

        file_put_contents($this->cacheFile, json_encode($seenArray));
        unset($seenArray);

        return $this;
    }

    /**
     * @param string $nickname
     * @return false if no record is available, string if we found date
     */
    private function readFromSeen($nickname)
    {
        $result = false;

        $seenFile = file_get_contents($this->cacheFile);

        if (false !== $seenFile) {
            $seenArray = json_decode($seenFile, true);

            unset($seenFile);
        } else {
            $seenArray = array();
        }

        if (isset($seenArray[$nickname])) {
            $result = $seenArray[$nickname];
        }

        unset($seenArray);

        return $result;
    }

    /**
     * @param string $cacheDir
     */
    public function setCacheDir($cacheDir)
    {
        $this->cacheFile = $cacheDir.DIRECTORY_SEPARATOR.'irc-bot-bundle-seen.json';
    }
}

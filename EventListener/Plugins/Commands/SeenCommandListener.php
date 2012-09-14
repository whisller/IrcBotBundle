<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins\Commands;

use Whisnet\IrcBotBundle\EventListener\Plugins\Commands\CommandListener;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;
use Whisnet\IrcBotBundle\Event\IrcCommandFoundEvent;

/**
 * Listener is adding "last seen" functionality.
 * It read and update information about last seen of user.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class SeenCommandListener extends CommandListener
{
    /**
     * @var string
     */
    private $cacheFile;

    /**
     * {@inheritdoc}
     */
    public function onCommand(BotCommandFoundEvent $event)
    {
        $arguments = $event->getArguments();

        if (!isset($arguments[0])) {
            $this->noNickname($event);
        } else {
            $seen = $this->readFromSeen($arguments[0]);
            if ($seen) {
                $this->sendMessage(array($event->getChannel()), $event->getNickname().' I\'ve seen '.$arguments[0].' at '.$seen);
            } else {
                $this->noInformationAvailable($event);
            }
        }
    }

    /**
     * @param IrcCommandFoundEvent $event
     * @throws CommandException
     * @return boolean
     */
    public function onUpdateInformation(IrcCommandFoundEvent $event)
    {
        $data = $event->getData();

        $dateTime = new \DateTime('now', new \DateTimeZone(date_default_timezone_get()));

        $this->writeToSeen($event->getNickname(), $dateTime->format('Y-m-d H:i:s'));

        unset($dateTime);
        unset($data);
    }

    /**
     * @param BotCommandFoundEvent $event
     */
    private function noInformationAvailable(BotCommandFoundEvent $event)
    {
        $arguments = $event->getArguments();

        $this->sendMessage(array($event->getChannel()), 'Sorry '.$event->getNickname().' I don\'t have information about '.$arguments[0]);
    }

    /**
     * @param BotCommandFoundEvent $event
     */
    private function noNickname(BotCommandFoundEvent $event)
    {
        $this->sendMessage(array($event->getChannel()), $event->getNickname().' who are you looking for?');
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

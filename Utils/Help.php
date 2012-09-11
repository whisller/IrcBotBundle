<?php
namespace Whisnet\IrcBotBundle\Utils;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class Help
{
    /**
     * @var array
     */
    protected static $helps = array();

    /**
     * @param string $command
     * @param string $help
     * @param array $arguments
     */
    public function add($command, $help = '', $arguments = array())
    {
        self::$helps[$command] = array($help, $arguments);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return self::$helps;
    }
}

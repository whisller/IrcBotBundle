<?php
namespace Whisnet\IrcBotBundle\Utils;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class Utils
{
    /**
     * @param string $data
     * @return string
     */
    public static function cleanUpServerRequest($data)
    {
        return preg_replace('/[\r\n]/', '', $data);
    }
}

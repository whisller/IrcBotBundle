<?php
namespace Whisnet\IrcBotBundle\Utils;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class Utils
{
    /**
     * @param  string $data
     * @return mixed
     */
    public static function cleanUpServerRequest($data)
    {
        return preg_replace('/[\r\n]/', '', $data);
    }
}

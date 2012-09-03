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
    public static function cleanUpServeRequest($data)
    {
        $patterns[0] = "/\r/";
        $patterns[1] = "/\r\n/";
        $patterns[2] = "/\n/";
        $replacements[0] = '';
        $replacements[1] = '';
        $replacements[2] = '';
        $data = preg_replace($patterns, $replacements, $data);

        return $data;
    }
}

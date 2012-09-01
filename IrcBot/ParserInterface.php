<?php
namespace Whisnet\IrcBotBundle\IrcBot;

interface ParserInterface
{
    public function parse($data, $conn);
}

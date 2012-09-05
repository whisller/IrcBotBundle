<?php
/**
 * User: mike
 * Date: 05.09.2012
 * Time: 09:48
 */

namespace Whisnet\IrcBotBundle\IrcCommands\Interfaces;

interface Command {
    public function setValidator(ValidatorInterface $validator);
    public function validate();
    public function asData();
}
<?php
namespace Whisnet\IrcBotBundle\IrcCommands\Interfaces;

use Symfony\Component\Validator\ValidatorInterface;

interface CommandInterface
{
    /**
     * Set validator that will be used for validate arguments.
     * @return void
     */
    public function setValidator(ValidatorInterface $validator);

    /**
     * Validate arguments for command.
     *
     * @return boolean
     * @throws CommandException
     */
    public function validate();

    /**
     * @return string
     */
    public function __toString();
}

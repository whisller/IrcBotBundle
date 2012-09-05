<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\ValidatorInterface;
use Whisnet\IrcBotBundle\IrcCommands\Interfaces\Command as CommandInterface;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
abstract class Command implements CommandInterface
{
    const POSTFIX = "\r";

    /**
     * @var ValidatorInterface
     */
    protected $validator = null;

    /**
     * @return boolean
     * @throws CommandException
     */
    public function validate()
    {
        $errors = $this->validator->validate($this);

        if (0 < count($errors)) {
            $errorMessages = array();

            foreach ($errors as $error) {
                $errorMessages[] = (string)$error;
            }

            throw new CommandException(implode("\n", $errorMessages));
        }

        return true;
    }

    public function setValidator(ValidatorInterface $validator) {
        if($this->validator == null) {
            $this->validator = $validator;
        }
    }

    /**
     * Return name of the command.
     *
     * @return string
     */
    abstract protected function getName();

    /**
     * Parse arguments and implode it to one string.
     *
     * @return string
     */
    abstract protected function getArguments();

    public function asData() {
        return (string)$this;
    }

    /**
     * Return prepared command with arguments.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName().' '.$this->getArguments().Command::POSTFIX;
    }
}

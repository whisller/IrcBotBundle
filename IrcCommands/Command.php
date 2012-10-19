<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\ValidatorInterface;

use Whisnet\IrcBotBundle\IrcCommands\Interfaces\CommandInterface;
use Whisnet\IrcBotBundle\IrcCommands\Exceptions\CommandException;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
abstract class Command implements CommandInterface
{
    const POSTFIX = "\r";

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function setValidator(ValidatorInterface $validator)
    {
        if ($this->validator == null) {
            $this->validator = $validator;
        }
    }

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
                $errorMessages[] = (string) $error;
            }

            throw new CommandException(implode("\n", $errorMessages));
        }

        return true;
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

    /**
     * Return prepared command with arguments.
     *
     * @return string
     */
    public function __toString()
    {
        $result = $this->getName();
        $result .= 0 < mb_strlen($this->getArguments()) ? (' '.$this->getArguments()) : '';
        $result .= Command::POSTFIX;

        return $result;
    }
}

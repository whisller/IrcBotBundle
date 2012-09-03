<?php
namespace Whisnet\IrcBotBundle\Commands;

use Symfony\Component\Validator\ValidatorInterface;

abstract class Command
{
    const POSTFIX = "\r";

    protected $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

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

    abstract protected function getName();
    abstract protected function getArguments();

    public function __toString()
    {
        return  $this->getName().' '.$this->getArguments().Command::POSTFIX;
    }
}

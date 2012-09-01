<?php
namespace Whisnet\IrcBotBundle\Commands;

abstract class Command
{
    const POSTFIX = "\r\n";

    protected $args = array();

    public function __construct(array $args = array())
    {
        $this->args = $args;

        $this->validate();
    }

    abstract protected function getName();
    abstract protected function validate();
    abstract protected function getArguments();

    public function __toString()
    {
        return $this->getName().' '.$this->getArguments().Command::POSTFIX;
    }
}

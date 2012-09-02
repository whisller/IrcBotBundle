<?php
namespace Whisnet\IrcBotBundle\Parse;

abstract class Parse
{
    protected $successor;
    protected $arguments = array();

    public function __construct(array $arguments = array())
    {
        $this->arguments = $arguments;
    }

    public function setSuccessor(Parse $successor)
    {
        $this->successor = $successor;
    }

    abstract public function parse($data);
}

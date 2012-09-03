<?php
namespace Whisnet\IrcBotBundle\EventListener;

use Symfony\Component\Validator\ValidatorInterface;

use Whisnet\IrcBotBundle\Event\CommandEvent;

abstract class BaseListener
{
    protected $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
}

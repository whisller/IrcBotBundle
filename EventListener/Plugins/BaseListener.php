<?php
namespace Whisnet\IrcBotBundle\EventListener\Plugins;

use Symfony\Component\Validator\ValidatorInterface;

use Whisnet\IrcBotBundle\Event\CommandEvent;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
abstract class BaseListener
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
}

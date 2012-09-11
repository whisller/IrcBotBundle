<?php
namespace Whisnet\IrcBotBundle\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class CommandInfo extends Annotation
{
    /**
     * Command name.
     *
     * @var string
     */
    public $name;

    /**
     * Help for the command.
     *
     * @var string
     */
    public $help;

    /**
     * Array with available arguments.
     *
     * @var array
     */
    public $arguments;
}

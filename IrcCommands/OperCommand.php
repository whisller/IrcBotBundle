<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * http://tools.ietf.org/html/rfc2812#section-3.1.4
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class OperCommand extends Command
{
    /**
     * @var string
     * @NotBlank()
     */
    private $name;

    /**
     * @var string
     * @NotBlank()
     */
    private $password;

    /**
     * @return string
     */
    public function getName()
    {
        return 'OPER';
    }

    /**
     * @param string $name
     * @param string $password
     */
    public function __construct($name, $password)
    {
        $this->setName($name);
        $this->setPassword($password);
    }

    /**
     * @param string $name
     * @return OperCommand
     */
    protected function setName($name)
    {
        $this->name = trim($name);

        return $this;
    }

    /**
     * @param string $password
     * @return OperCommand
     */
    protected function setPassword($password)
    {
        $this->password = trim($password);

        return $this;
    }

    /**
     * @return string
     */
    protected function getArguments()
    {
        $result = $this->name.' '.$this->password;

        return $result;
    }
}

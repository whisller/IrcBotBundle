<?php
namespace Whisnet\IrcBotBundle\IrcCommands;

use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * http://tools.ietf.org/html/rfc2812#section-3.1.1
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class PassCommand extends Command
{
    /**
     * @NotBlank()
     */
    private $password;

    /**
     * @return string
     */
    public function getName()
    {
        return 'PASS';
    }

    /**
     * @param string $password
     */
    public function __construct($password)
    {
        $this->setPassword($password);
    }

    /**
     * @param  string      $password
     * @return PassCommand
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
        $result = $this->password;

        return $result;
    }
}

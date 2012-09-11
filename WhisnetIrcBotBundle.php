<?php

namespace Whisnet\IrcBotBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;

use Whisnet\IrcBotBundle\DependencyInjection\Compiler\HelpReadPass;

/**
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class WhisnetIrcBotBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new HelpReadPass());
    }
}

<?php
namespace Whisnet\IrcBotBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * @author Daniel Ancuta <whsiller@gmail.com>
 */
class HelpReadPass implements CompilerPassInterface
{
    /**
     * @see Symfony\Component\DependencyInjection\Compiler.CompilerPassInterface::process()
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('whisnet_irc_bot.commands_info_holder')) {
            return;
        }

        $taggedServiceHolder = $container->getDefinition('whisnet_irc_bot.commands_info_holder');

        foreach ($container->findTaggedServiceIds('whisnet_irc_bot.bot_command') as $id => $attributes) {
            $taggedServiceHolder->addMethodCall('push', array($attributes));
        }
    }
}
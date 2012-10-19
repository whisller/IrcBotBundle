<?php

namespace Whisnet\IrcBotBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class WhisnetIrcBotExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        foreach (array('core', 'server_messages', 'commands') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }

        $container->setParameter('whisnet_irc_bot.connection_class', $config['connection_class']);
        $container->setParameter('whisnet_irc_bot.user', $config['user']);
        //$container->setParameter('whisnet_irc_bot.password', $config['password']);
        $container->setParameter('whisnet_irc_bot.transport', $config['transport']);
        $container->setParameter('whisnet_irc_bot.host', $config['host']);
        $container->setParameter('whisnet_irc_bot.port', $config['port']);
        $container->setParameter('whisnet_irc_bot.channels', $config['channels']);
        $container->setParameter('whisnet_irc_bot.bot_command_prefix', $config['command_prefix']);

        if (!$container->hasDefinition('whisnet_irc_bot.commands_info_holder')) {
            $taggedServiceHolder = new Definition();
            $taggedServiceHolder->setClass('SplDoublyLinkedList');
            $container->setDefinition('whisnet_irc_bot.commands_info_holder', $taggedServiceHolder);
        }
    }
}

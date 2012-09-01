<?php

namespace Whisnet\IrcBotBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('whisnet_irc_bot');

        $rootNode
            ->children()
                ->arrayNode('servers')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('host')->defaultValue('irc.freenode.net')->end()
                            ->scalarNode('port')->defaultValue('6667')->end()
                            ->scalarNode('irc_class')->defaultValue('IRC_CLASS')->end()
                            ->scalarNode('parser_class')->defaultValue('PARSE_CLASS')->end()
                            ->scalarNode('command_prefix')
                                ->defaultValue('!bot')
                                ->beforeNormalization()
                                    ->ifString()->then(function($v){ return preg_quote($v); })
                                ->end()
                            ->end()
                            ->arrayNode('user')
                            ->isRequired()
                                ->children()
                                    ->scalarNode('username')->defaultValue('IrcBotBundle')->end()
                                    ->scalarNode('hostname')->defaultValue('example.com')->end()
                                    ->scalarNode('realname')->defaultValue('IrcBotBundle')->end()
                                ->end()
                            ->end()
                            ->arrayNode('channels')
                            ->isRequired()
                            ->requiresAtLeastOneElement()
                            ->useAttributeAsKey('name')
                                ->prototype('scalar')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}

<?php

namespace Mrogelja\ConnectCompassBundle\DependencyInjection;

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

        $seetingNode =  $treeBuilder->root('settings');

        $seetingNode->children()
            ->scalarNode('proxy_type')
                ->validate()
                ->ifNotInArray(array('pdo', 'propel', 'doctrine'))
                    ->thenInvalid('Invalid proxy type. Choose in [pdo, propel, doctrine]')
                ->end()
            ->end()
            ->arrayNode('connection')
                ->children()
                    ->arrayNode('pdo')
                        ->children()
                            ->scalarNode('table')->end()
                            ->scalarNode('variable_name_col')->end()
                            ->scalarNode('variable_value_col')->end()
                            ->scalarNode('variable_comment_col')->end()
                        ->end()
                    ->end()
                    ->arrayNode('propel')
                        ->children()
                            ->scalarNode('model')->end()
                            ->scalarNode('variable_name_property')->end()
                            ->scalarNode('variable_value_property')->end()
                            ->scalarNode('variable_comment_property')->end()
                            ->scalarNode('variable_updated_at_property')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        $rootNode = $treeBuilder->root('mrogelja_connect_compass');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $rootNode->children()
            ->scalarNode('register_listener')->end()
            ->append($seetingNode)
            ->arrayNode('compass_projects')
                ->prototype('array')
                    ->children()
                        ->append($seetingNode)
                        ->scalarNode('path')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
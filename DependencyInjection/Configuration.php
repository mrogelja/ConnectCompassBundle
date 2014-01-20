<?php

namespace Mr\ConnectCompassBundle\DependencyInjection;

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

        $settingNode =  $treeBuilder->root('settings');

        $settingNode->children()
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
                            ->scalarNode('variable_type_property')->end()
                            ->scalarNode('variable_updated_at_property')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        $templatingNode =  $treeBuilder->root('templating');

        $templatingNode->children()
            ->scalarNode('engine')
                ->defaultValue('twig')
            ->end()
            ->arrayNode('views')
                ->children()
                    ->arrayNode('sass_variable')
                        ->children()
                            ->scalarNode('list')->end()
                            ->scalarNode('update')->end()
                            ->scalarNode('delete')->end()
                            ->scalarNode('add')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        $rootNode = $treeBuilder->root('mr_connect_compass');

        $rootNode->children()
            ->scalarNode('register_listener')->end()
            ->append($settingNode)
            ->append($templatingNode)
            ->arrayNode('compass_projects')
                ->prototype('array')
                    ->children()
                        ->append($settingNode)
                        ->scalarNode('path')->end()
                        ->scalarNode('name')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
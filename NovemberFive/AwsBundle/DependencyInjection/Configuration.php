<?php
/**
 * This file is part of lib_serverside_awsbundle.
 *
 * (c) 2016 November Five BVBA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NovemberFive\AwsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link
 * http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('november_five_aws');

        $rootNode->children()
            ->arrayNode('aws')
                ->children()
                    ->scalarNode('access_key')->defaultNull()->info('Access key - default uses instance profile -')->end()
                    ->scalarNode('secret_key')->defaultNull()->info('Secret key - default uses instance profile -')->end()
                    ->scalarNode('region')->defaultValue('eu-west-1')->end()
                    ->scalarNode('proxy')->defaultNull()->end()
                ->end()
            ->end()
        ->end();

        $rootNode->children()
            ->arrayNode('kms')
                ->children()
                    ->scalarNode('secret')->defaultNull()->end()
                    ->scalarNode('version')->defaultValue('2014-11-01')->end()
                ->end()
            ->end()
        ->end();

        $rootNode->children()
            ->arrayNode('sqs')
                ->children()
                    ->scalarNode('version')->defaultValue('2012-11-05')->end()
                ->end()
            ->end()
        ->end();

        $rootNode->children()
            ->arrayNode('sns')
                ->children()
                    ->scalarNode('version')->defaultValue('2010-03-31')->end()
                ->end()
            ->end()
        ->end();

        $rootNode->children()
            ->arrayNode('s3')
                ->children()
                    ->scalarNode('version')->defaultValue('2006-03-01')->end()
                ->end()
            ->end()
        ->end();

        $rootNode->children()
            ->arrayNode('dynamodb')
                ->children()
                    ->scalarNode('version')->defaultValue('2012-08-10')->end()
                ->end()
            ->end()
        ->end();

        $rootNode->children()
            ->arrayNode('lambda')
                ->children()
                    ->scalarNode('version')->defaultValue('latest')->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}

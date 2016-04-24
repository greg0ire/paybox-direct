<?php

namespace Nexy\PayboxDirect\Bundle\DependencyInjection;

use Nexy\PayboxDirect\Enum\Currency;
use Nexy\PayboxDirect\Paybox;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nexy_paybox_direct');

        $rootNode
            ->children()
                ->scalarNode('client')->defaultNull()->end()
                ->arrayNode('options')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->integerNode('timeout')->end()
                        ->booleanNode('production')->end()
                    ->end()
                ->end()
                ->arrayNode('paybox')
                    ->isRequired()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('version')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->validate()
                                ->ifNotInArray(array_keys(Paybox::VERSIONS))
                                ->thenInvalid('Invalid Paybox version')
                            ->end()
                        ->end()
                        ->scalarNode('site')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('rank')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('identifier')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('key')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('default_currency')
                            ->validate()
                                ->ifNotInArray(array_keys(Currency::ALL))
                                ->thenInvalid('Invalid Paybox version')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
<?php

namespace Quartet\Payment\ManuallyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();

        $root = $builder->root('quartet_payment_manually');

        $root
            ->children()
                ->arrayNode('payment_methods')
                    ->isRequired()
                    ->prototype('scalar')
                    ->end()
                ->end()
            ->end()
        ;

        return $builder;
    }
}

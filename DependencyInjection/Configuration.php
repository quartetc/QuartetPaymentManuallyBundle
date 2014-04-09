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
                ->scalarNode('payment_method')->isRequired()->end()
            ->end()
        ;

        return $builder;
    }
}

<?php

namespace Quartet\Payment\ManuallyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class QuartetPaymentManuallyExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($configuration = new Configuration(), $configs);

        $container->setAlias('quartet_payment_manually.payment_method', $config['payment_method']);
    }
}

<?php

namespace Quartet\Payment\ManuallyBundle\Tests\DependencyInjection;

use Quartet\Payment\ManuallyBundle\DependencyInjection\QuartetPaymentManuallyExtension;

class QuartetPaymentManuallyExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var QuartetPaymentManuallyExtension
     */
    private $extension;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder|\PHPUnit_Framework_MockObject_MockObject
     */
    private $container;

    protected function setUp()
    {
        $this->extension = new QuartetPaymentManuallyExtension();
        $this->container = $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder');
    }

    /**
     * @test
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage "payment_method"
     */
    public function testThrowExceptionUnlessSetPaymentMethod()
    {
        $this->extension->load(array(array()), $this->container);
    }

    /**
     * @test
     */
    public function testPaymentMethodAlias()
    {
        $this
            ->container
            ->expects($this->once())
            ->method('setAlias')
            ->with($this->equalTo('quartet_payment_manually.payment_method'), $this->equalTo('acme_payment_method'));

        $this->extension->load(array(array(
            'payment_method' => 'acme_payment_method'
        )), $this->container);
    }
}

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
        $this->container = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->setMethods(array('setAlias'))
            ->getMock()
        ;
    }

    /**
     * @test
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage "payment_methods"
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
            ->expects($this->at(0))
            ->method('setAlias')
            ->with($this->equalTo('quartet_payment_manually.payment_method.a'), $this->equalTo('acme_payment_method_a'))
        ;

        $this
            ->container
            ->expects($this->at(1))
            ->method('setAlias')
            ->with($this->equalTo('quartet_payment_manually.payment_method.b'), $this->equalTo('acme_payment_method_b'))
        ;

        $this->extension->load(array(array(
            'payment_methods' => array(
                'a' => 'acme_payment_method_a',
                'b' => 'acme_payment_method_b',
            )
        )), $this->container)
        ;
    }
}

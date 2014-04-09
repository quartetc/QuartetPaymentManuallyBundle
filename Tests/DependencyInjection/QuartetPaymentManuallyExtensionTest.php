<?php

namespace Quartet\Payment\ManuallyBundle\Tests\DependencyInjection;

use Quartet\Payment\ManuallyBundle\DependencyInjection\QuartetPaymentManuallyExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

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
    public function testAddTagToPaymentMethod()
    {
        $definition = $this
            ->getMockBuilder('Symfony\Component\DependencyInjection\Definition')
            ->disableOriginalConstructor()
            ->getMock();

        $definition
            ->expects($this->once())
            ->method('addTag')
            ->with('payment.method_type');

        $this
            ->container
            ->expects($this->any())
            ->method('getDefinition')
            ->with($this->equalTo('acme_payment_method'))
            ->will($this->returnValue($definition));

        $this->extension->load(array(array(
            'payment_method' => 'acme_payment_method'
        )), $this->container);
    }

    /**
     * @test
     * @depends testAddTagToPaymentMethod
     */
    public function testPaymentMethodAlias()
    {
        $definition = $this
            ->getMockBuilder('Symfony\Component\DependencyInjection\Definition')
            ->disableOriginalConstructor()
            ->getMock();

        $this
            ->container
            ->expects($this->any())
            ->method('getDefinition')
            ->with($this->equalTo('acme_payment_method'))
            ->will($this->returnValue($definition));

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

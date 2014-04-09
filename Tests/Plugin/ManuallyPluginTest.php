<?php

namespace Quartet\Payment\ManuallyBundle\Tests\Plugin;

use Quartet\Payment\ManuallyBundle\Plugin\ManuallyPlugin;

class ManuallyPluginTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Symfony\Component\Form\FormTypeInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $paymentMethod;

    /**
     * @var ManuallyPlugin
     */
    private $plugin;

    protected function setUp()
    {
        $this->paymentMethod = $this->getMock('Symfony\Component\Form\FormTypeInterface');

        $this->plugin = new ManuallyPlugin($this->paymentMethod);
    }

    /**
     * @test
     */
    public function testProcesses()
    {
        $this
            ->paymentMethod
            ->expects($this->atLeastOnce())
            ->method('getName')
            ->will($this->returnValue('acme_type'));

        $this->assertFalse($this->plugin->processes('hoge'));
        $this->assertTrue($this->plugin->processes('acme_type'));
    }

}

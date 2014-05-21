<?php

namespace Quartet\Payment\ManuallyBundle\Tests\Plugin;

use JMS\Payment\CoreBundle\Entity\FinancialTransaction;
use JMS\Payment\CoreBundle\Model\FinancialTransactionInterface;
use JMS\Payment\CoreBundle\Plugin\PluginInterface;
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

    /**
     * @test
     */
    public function testApprove()
    {
        $transaction = $this->getTransaction();
        $transaction->setRequestedAmount(9000);

        $this->assertEquals(0.0, $transaction->getProcessedAmount());

        $this->plugin->approve($transaction, false);

        $this->assertEquals(PluginInterface::RESPONSE_CODE_SUCCESS, $transaction->getResponseCode());
        $this->assertEquals(9000, $transaction->getProcessedAmount());
    }

    /**
     * @test
     */
    public function testDeposit()
    {
        $transaction = $this->getTransaction();
        $transaction->setRequestedAmount(9000);

        $this->plugin->deposit($transaction, false);

        $this->assertEquals(PluginInterface::RESPONSE_CODE_SUCCESS, $transaction->getResponseCode());
        $this->assertEquals(9000, $transaction->getProcessedAmount());
    }

    /**
     * @return FinancialTransactionInterface
     */
    private function getTransaction()
    {
        return new FinancialTransaction();
    }

}

<?php

namespace Quartet\Payment\ManuallyBundle\Plugin;

use JMS\Payment\CoreBundle\Model\FinancialTransactionInterface;
use JMS\Payment\CoreBundle\Plugin\AbstractPlugin;
use Symfony\Component\Form\FormTypeInterface;

class ManuallyPlugin extends AbstractPlugin
{
    /**
     * @var \Symfony\Component\Form\FormTypeInterface
     */
    private $paymentMethod;

    /**
     * @param FormTypeInterface $paymentMethod
     */
    public function __construct(FormTypeInterface $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * {@inheritdoc}
     */
    public function approve(FinancialTransactionInterface $transaction, $retry)
    {
        $transaction->setProcessedAmount($transaction->getRequestedAmount());
        $transaction->setResponseCode(self::RESPONSE_CODE_SUCCESS);
    }

    /**
     * {@inheritdoc}
     */
    public function deposit(FinancialTransactionInterface $transaction, $retry)
    {
        $transaction->setProcessedAmount($transaction->getRequestedAmount());
        $transaction->setResponseCode(self::RESPONSE_CODE_SUCCESS);
    }

    /**
     * {@inheritdoc}
     */
    function processes($paymentSystemName)
    {
        return $this->paymentMethod->getName() === $paymentSystemName;
    }
}

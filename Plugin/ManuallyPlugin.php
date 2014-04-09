<?php

namespace Quartet\Payment\ManuallyBundle\Plugin;

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
    function processes($paymentSystemName)
    {
        return $this->paymentMethod->getName() === $paymentSystemName;
    }
}

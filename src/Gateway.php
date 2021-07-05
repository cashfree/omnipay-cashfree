<?php

/**
 * Cashfree Charge Gateway.
 */
namespace Omnipay\Cashfree;

use Omnipay\Common\AbstractGateway;

/**
 * Cashfree Charge Gateway.
 *
 * @see \Omnipay\Cashfree\AbstractGateway
 * @see \Omnipay\Cashfree\Message\AbstractRequest
 *
 * @link https://dev.cashfree.com/payment-gateway-api
 *
 */
class Gateway extends AbstractGateway
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Cashfree';
    }

    public function getDefaultParameters()
    {
        return array(
            'app_id' => '', //Check cashfree dashboad for these detail
            'secret_key' => '',
            'sandbox' => true //True in case of you use test evnironment
        );
    }

    public function getAppID()
    {
        return $this->getParameter('app_id');
    }

    public function setAppID($value)
    {
        return $this->setParameter('app_id', $value);
    }

    public function getSecretKey()
    {
        return $this->getParameter('secret_key');
    }

    public function setSecretKey($value)
    {
        return $this->setParameter('secret_key', $value);
    }

    public function getTestMode()
    {
        return $this->getParameter('sandbox');
    }

    public function setTestMode($value)
    {
        return $this->setParameter('sandbox', $value);
    }

    /**
     * Creating the Purchase Request
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Cashfree\Message\PaymentIntents\PurchaseRequest', $parameters);
    }

    /**
     * Verifying the Purchase Request
     */
    public function completePurchase(array $parameters = array())
    {
        $parameters['secret_key'] = $this->getSecretKey();
        return $this->createRequest('\Omnipay\Cashfree\Message\CompletePurchaseRequest', $parameters);
    }
    public function acceptNotification(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Cashfree\Message\NotifyRequest', $parameters);
    }

}

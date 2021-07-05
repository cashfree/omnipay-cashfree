<?php

/**
 * Cashfree Payment Intents Purchase Request.
 */
namespace Omnipay\Cashfree\Message\PaymentIntents;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Cashfree Complete Purchase Request. For Off-Site payment.
 */
class PurchaseRequest extends AbstractRequest
{
	public function getData()
	{
        if (!empty($this->getCard()))
        {
            $card = $this->getCard();
            $hmacKey = $this->getSecretKey();

            $data = array(
                    'appId'         => $this->getAppID(),
                    'orderAmount'   => $this->getAmount(), // in rupee
                    'orderCurrency' => $this->getCurrency(),
                    'customerEmail' => $card->getEmail(),
                    'customerName'  => $card->getFirstName(),
                    'customerPhone' => $card->getPhone(),
                    'orderNote'     => $this->getDescription(),
                    'orderId'       => $this->getTransactionId(),
                    'signature'     => '',
                    'returnUrl'     => $this->getReturnUrl(),
                    'notifyUrl'     => $this->getNotifyUrl()
                );

            $cashfreeSignature = new Signature($hmacKey);
            $signature = $cashfreeSignature->getSignature($data);

            $data['signature'] = $signature;
            return $data;
        }

        // Default case
        return $this->getParameters();
	}

    public function sendData($data)
    {
        return $this->createResponse($data);
    }

    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
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
}
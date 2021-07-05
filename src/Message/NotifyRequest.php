<?php

namespace Omnipay\Cashfree\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Class NotifyRequest
 * @package Omnipay\Cashfree\Message
 */
class NotifyRequest extends AbstractRequest
{

    public function getData()
    {
        if (!isset($this->data)) {
            $data = $this->httpRequest->request->all();

            if (!isset($data['signature'])) {
                throw new InvalidRequestException("The signature parameter is required");
            }

            $signature_provided = $data['signature'];  // Get the Signature from the POST data
            $orderId            = $data["orderId"];
            $orderAmount        = $data["orderAmount"];
            $referenceId        = $data["referenceId"];
            $txStatus           = $data["txStatus"];
            $paymentMode        = $data["paymentMode"];
            $txMsg              = $data["txMsg"];
            $txTime             = $data["txTime"];
            $data               = $orderId.$orderAmount.$referenceId.$txStatus.$paymentMode.$txMsg.$txTime;
            $hash_hmac = hash_hmac('sha256', $data, $this->getSecretKey(), true) ;
            $computedSignature = base64_encode($hash_hmac);
            if ($signature_provided == $computedSignature) {
                $this->data = $data;
            } else {
                throw new InvalidRequestException("Signature mismatch");
            }
        }

        return $this->data;
    }

    /**
     * @param mixed $data
     * @return NotifyResponse
     */
    public function sendData($data)
    {
        return $this->response = new NotifyResponse($this, $data);
    }
}

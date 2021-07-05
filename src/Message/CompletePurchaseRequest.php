<?php
/**
 * CreateSourceRequest
 */
namespace Omnipay\Cashfree\Message;

use Omnipay\Cashfree\Message\PaymentIntents\PurchaseRequest;

/**
 * Class CreateSourceRequest
 */
class CompletePurchaseRequest extends PurchaseRequest
{
    /**
     * Sending data to Response class
     */
    protected function createResponse($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}

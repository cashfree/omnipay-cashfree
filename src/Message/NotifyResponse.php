<?php

namespace Omnipay\Cashfree\Message;

/**
 * Class NotifyResponse
 * @package Omnipay\Cashfree\Message
 */
class NotifyResponse extends Response
{

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return !empty($this->data['txStatus']);
    }

    /**
     * @return mixed
     */
    public function getTransactionReference()
    {
        if (isset($this->data['referenceId'])) {
            return $this->data['referenceId'];
        }

        return null;
    }

    /**
     * Was the transaction successful?
     *
     * @return string Transaction status, one of {@see STATUS_COMPLETED}, {@see #STATUS_PENDING},
     * or {@see #STATUS_FAILED}.
     */
    public function getTransactionStatus()
    {
        if (isset($this->data['txStatus']) && 'SUCCESS' == $this->data['txStatus']) {
            return static::STATUS_COMPLETED;
        }

        return static::STATUS_FAILED;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        if (isset($this->data['orderAmount'])) {
            return $this->data['orderAmount'];
        }

        return null;
    }

}

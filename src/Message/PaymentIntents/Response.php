<?php

namespace Omnipay\Cashfree\Message\PaymentIntents;

use GuzzleHttp;
use Omnipay\Cashfree\Gateway;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Cashfree Purchase Response - implements RedirectResponseInterface, so the constructor is taken care of
 */
class Response extends AbstractResponse implements RedirectResponseInterface
{
    public function __construct($request, $data)
    {
        $this->request = $request;
        $this->data = $data;
    }

    /**
     * @var string
     */
    protected $liveEndpoint = 'https://www.cashfree.com/checkout/post/submit';
    /**
     * @var string
     */
    protected $testEndpoint = 'https://test.cashfree.com/billpay/checkout/post/submit';

    public function getRedirectUrl()
    {
        $gateway = new Gateway();
        $testMode = $gateway->getTestMode();
     
        $endpoint = $testMode ? $this->testEndpoint : $this->liveEndpoint;
        return $endpoint;
        
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        return $this->data;
    }

    public function redirect(){}

    public function isRedirect()
    {
        return true;
    }

    public function isSuccessful()
    {
        return false;
    }
} 
<?php

namespace Omnipay\Cashfree\Message;

use Omnipay\Cashfree\Message\PaymentIntents\Response;
use Omnipay\Cashfree\Message\PaymentIntents\Signature;

class CompletePurchaseResponse extends Response
{
    public function isSuccessful()
    {
        if (!empty($_POST['referenceId']))
        {
            if($_POST['txStatus'] == 'SUCCESS')
            {
                return $this->signatureVerification($_POST);
            }
            else {
                return false;
            }
        }

        return false;
    }

    protected function signatureVerification($data)
    {
        $configData = parent::getRedirectData();
        $secretkey = $configData['secret_key'];
        $verifySignature = new Signature($secretkey);
        $computedSignature = $verifySignature->computedSignature($data);

        $signature      = $data["signature"];
        if ($signature == $computedSignature) {
            return true;
        } else {
            return false;
        }
    }
}

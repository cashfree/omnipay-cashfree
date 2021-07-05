<?php

namespace Omnipay\Cashfree\Message\PaymentIntents;

class Signature
{
	public function __construct($key)
	{
		$this->key = $key;
	}

	public function getSignature(array $data)
    {
        $postData = array(
            "appId"         => $data['appId'],
            "orderId"       => $data['orderId'],
            "orderAmount"   => $data['orderAmount'],
            "orderCurrency" => $data['orderCurrency'],
            "orderNote"     => $data['orderNote'],
            "customerName"  => $data['customerName'],
            "customerPhone" => $data['customerPhone'],
            "customerEmail" => $data['customerEmail'],
            "returnUrl"     => $data['returnUrl'],
            "notifyUrl"     => $data['notifyUrl'],
        );
        // get secret key from your config
        ksort($postData);
        $signatureData = "";
        foreach ($postData as $key => $value){
            $signatureData .= $key.$value;
        }
        
        $signature = hash_hmac('sha256', $signatureData, $this->key, true);
        $signature = base64_encode($signature);
        return $signature;
    }

    public function computedSignature(array $data)
    {
        $orderId        = $data["orderId"];
        $orderAmount    = $data["orderAmount"];
        $referenceId    = $data["referenceId"];
        $txStatus       = $data["txStatus"];
        $paymentMode    = $data["paymentMode"];
        $txMsg          = $data["txMsg"];
        $txTime         = $data["txTime"];
        $data           = $orderId.$orderAmount.$referenceId.$txStatus.$paymentMode.$txMsg.$txTime;
        $hash_hmac      = hash_hmac('sha256', $data, $this->key, true) ;
        $computedSignature = base64_encode($hash_hmac);
        return $computedSignature;
    }
}
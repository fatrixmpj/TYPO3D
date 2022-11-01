<?php

namespace Omnipay\Ifthenpay\Message;

use Omnipay\Common\Exception\InvalidResponseException;

class CompletePurchaseRequest extends PurchaseRequest
{
    public function getData()
    {
        return $this->getParameters();
    }

    public function sendData($data)
    {
        if($this->getParameters()["ChaveAntiPhishing"]==$this->getParameters()["ChaveAntiPhishingCallback"])
        {
            $data["transStatus"] = 'Y';
        }
        
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}

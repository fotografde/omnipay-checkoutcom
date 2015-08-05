<?php
namespace Omnipay\CheckoutCom\Message;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionReference');
    }

    public function getHttpMethod()
    {
        return 'GET';
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/charges/'.$this->getTransactionReference();
    }
}

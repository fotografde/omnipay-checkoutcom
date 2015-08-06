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

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest($data);

        return $this->response = new AbstractResponse($this, $httpResponse->json());
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/charges/' . $this->getTransactionReference();
    }
}

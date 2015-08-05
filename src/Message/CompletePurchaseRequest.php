<?php
namespace Omnipay\CheckoutCom\Message;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionReference');

        $data = array();

        if ($amount = $this->getAmountInteger()) {
            $data['value'] = $amount;
        }

        return $data;
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/charges/'.$this->getTransactionReference() . '/capture';
    }
}

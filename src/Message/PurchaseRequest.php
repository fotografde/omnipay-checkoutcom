<?php
/**
 * CheckoutCom Purchase Request
 */

namespace Omnipay\CheckoutCom\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $data = parent::getData();
        $data['autoCapture'] = 1;

        return $data;
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/tokens/payment';
    }
}

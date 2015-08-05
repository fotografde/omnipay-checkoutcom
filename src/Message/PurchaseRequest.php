<?php
/**
 * CheckoutCom Purchase Request
 */

namespace Omnipay\CheckoutCom\Message;

class PurchaseRequest extends AuthorizeRequest
{
    public function getData()
    {
        $data = parent::getData();
        $data['autoCapture'] = 1;

        return $data;
    }
}

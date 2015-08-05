<?php
/**
 * CheckoutCom Purchase Request
 */

namespace Omnipay\CheckoutCom\Message;

/**
 * CheckoutCom Purchase Request
 *
 * @link https://www.checkout.com/docs/api/API-reference/payment-tokens/create-payment-token
 */
class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount', 'currency');

        $data = array();
        $data['value'] = $this->getAmountInteger();
        $data['currency'] = strtoupper($this->getCurrency());
        $data['description'] = $this->getDescription();
        $data['metadata'] = $this->getMetadata();

        if($udf = array_values($this->getUdf())) {
            $data['udf1'] = $udf[0];
            $data['udf2'] = isset($udf[1]) ? $udf[1] : null;
            $data['udf3'] = isset($udf[2]) ? $udf[2] : null;
            $data['udf4'] = isset($udf[3]) ? $udf[3] : null;
            $data['udf5'] = isset($udf[4]) ? $udf[4] : null;
        }

//        if ($this->getCardReference()) {
//            $data['customer'] = $this->getCardReference();
//        } elseif ($this->getToken()) {
//            $data['card'] = $this->getToken();
//        } elseif ($this->getCard()) {
//            $data['card'] = $this->getCardData();
//        } else {
//            // one of cardReference, token, or card is required
//            $this->validate('card');
//        }

        return $data;
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/tokens/payment';
    }
}

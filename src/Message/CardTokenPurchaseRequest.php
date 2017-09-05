<?php
/**
 * CheckoutCom Purchase Request
 */

namespace Omnipay\CheckoutCom\Message;

/**
 * CheckoutCom CardTokenPurchase Request
 *
 * @link https://docs.checkout.com/reference/merchant-api-reference/charges/charge-with-card-token
 */
class CardTokenPurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount', 'currency');

        $data = array();
        $data['value'] = $this->getAmountInteger();
        $data['currency'] = strtoupper($this->getCurrency());
        $data['description'] = $this->getDescription();
        $data['metadata'] = $this->getMetadata();
        $data['cardToken'] = $this->getCardToken();
        $data['email'] = $this->getEmail();


        if ($udf = $this->getUdfValues()) {
            $data['udf1'] = $udf[0];
            $data['udf2'] = isset($udf[1]) ? $udf[1] : null;
            $data['udf3'] = isset($udf[2]) ? $udf[2] : null;
            $data['udf4'] = isset($udf[3]) ? $udf[3] : null;
            $data['udf5'] = isset($udf[4]) ? $udf[4] : null;
        }

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest($data);

        return $this->response = new CardTokenPurchaseResponse($this, $httpResponse->json());
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/charges/token';
    }
}

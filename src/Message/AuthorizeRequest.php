<?php
/**
 * CheckoutCom Authorize Request
 */

namespace Omnipay\CheckoutCom\Message;

/**
 * CheckoutCom Authorize Request
 *
 * An Authorize request is similar to a purchase request but the
 * charge issues an authorization (or pre-authorization), and no money
 * is transferred.  The transaction will need to be captured later
 * in order to effect payment. Uncaptured charges expire in 7 days.
 *
 * @link https://www.checkout.com/docs/api/API-reference/payment-tokens/create-payment-token
 */
class AuthorizeRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount', 'currency');

        $data = array();
        $data['value'] = $this->getAmountInteger();
        $data['currency'] = strtoupper($this->getCurrency());
        $data['description'] = $this->getDescription();
        $data['metadata'] = $this->getMetadata();

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

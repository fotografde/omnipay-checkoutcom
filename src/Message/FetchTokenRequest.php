<?php
/**
 * Checkout.com Fetch Token Request
 */

namespace Omnipay\Checkoutcom\Message;

/**
 * Checkout.com Fetch Token Request
 *
 * @link https://stripe.com/docs/api#tokens
 */
class FetchTokenRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('token');

        $data = array();

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint.'/tokens/'.$this->getToken();
    }

    public function getHttpMethod()
    {
        return 'GET';
    }
}

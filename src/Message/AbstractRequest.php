<?php
/**
 * CheckoutCom Abstract Request
 */

namespace Omnipay\CheckoutCom\Message;

/**
 * CheckoutCom Abstract Request
 *
 * This is the parent class for all CheckoutCom requests.
 *
 * Test modes:
 *
 * CheckoutCom accounts have test-mode API keys as well as live-mode
 * API keys. These keys can be active at the same time. Data
 * created with test-mode credentials will never hit the credit
 * card networks and will never cost anyone money.
 *
 * Unlike some gateways, there is no test mode endpoint separate
 * to the live mode endpoint, the CheckoutCom API endpoint is the same
 * for test and for live.
 *
 * Setting the testMode flag on this gateway has no effect.  To
 * use test mode just use your test mode API key.
 *
 * You can use any of the cards listed at https://stripe.com/docs/testing
 * for testing.
 *
 * @see \Omnipay\CheckoutCom\Gateway
 * @link https://stripe.com/docs/api
 * @method \Omnipay\CheckoutCom\Message\Response send()
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * Live or Test Endpoint URL
     *
     * @var string URL
     */
    protected $liveEndpoint = 'https://sandbox.checkout.com/api2/v2'; //https://api2.checkout.com/v2
	protected $testEndpoint = 'https://sandbox.checkout.com/api2/v2';

	public function getSecretApiKey()
	{
		return $this->getParameter('secretApiKey');
	}

	public function setSecretApiKey($value)
	{
		return $this->setParameter('secretApiKey', $value);
	}

	public function getPublicApiKey()
	{
		return $this->getParameter('publicApiKey');
	}

	public function setPublicApiKey($value)
	{
		return $this->setParameter('publicApiKey', $value);
	}

    public function getEndpoint() {
		if($this->getTestMode()) {
			return $this->testEndpoint;
		}

		return $this->liveEndpoint;
	}

    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return 'POST';
    }

    public function sendData($data)
    {
        // don't throw exceptions for 4xx errors
        $this->httpClient->getEventDispatcher()->addListener(
            'request.error',
            function ($event) {
                if ($event['response']->isClientError()) {
                    $event->stopPropagation();
                }
            }
        );

        $httpRequest = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            null,
            json_encode($data)
        );

		$httpRequest
			->setHeader('Content-Type', 'application/json;charset=UTF-8')
			->setHeader('Accept', 'application/json')
			->setHeader('Authorization', $this->getSecretApiKey());

        $httpResponse = $httpRequest->send();

        return $this->response = new Response($this, $httpResponse->json());
    }

//    /**
//     * Get the card data.
//     *
//     * Because the stripe gateway uses a common format for passing
//     * card data to the API, this function can be called to get the
//     * data from the associated card object in the format that the
//     * API requires.
//     *
//     * @return array
//     */
//    protected function getCardData()
//    {
//        $this->getCard()->validate();
//
//        $data = array();
//        $data['number'] = $this->getCard()->getNumber();
//        $data['exp_month'] = $this->getCard()->getExpiryMonth();
//        $data['exp_year'] = $this->getCard()->getExpiryYear();
//        $data['cvc'] = $this->getCard()->getCvv();
//        $data['name'] = $this->getCard()->getName();
//        $data['address_line1'] = $this->getCard()->getAddress1();
//        $data['address_line2'] = $this->getCard()->getAddress2();
//        $data['address_city'] = $this->getCard()->getCity();
//        $data['address_zip'] = $this->getCard()->getPostcode();
//        $data['address_state'] = $this->getCard()->getState();
//        $data['address_country'] = $this->getCard()->getCountry();
//
//        return $data;
//    }
}

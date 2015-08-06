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
 * You can use any of the cards listed at
 * https://www.checkout.com/docs/api/integration-guide/charges/simulator
 * for testing.
 *
 * @see \Omnipay\CheckoutCom\Gateway
 * @link https://www.checkout.com/docs/sandbox/api
 * @method \Omnipay\CheckoutCom\Message\Response send()
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * Live or Test Endpoint URL
     *
     * @var string URL
     */
    protected $liveEndpoint = 'https://api2.checkout.com/v2';
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

    public function getMetadata()
    {
        return $this->getParameter('metadata');
    }

    public function setMetadata($value)
    {
        return $this->setParameter('metadata', $value);
    }

    public function getUdf()
    {
        return $this->getParameter('udf');
    }

    public function getUdfValues()
    {
        if ($udf = $this->getUdf()) {
            return array_values($udf);
        }

        return false;
    }

    public function setUdf($value)
    {
        return $this->setParameter('udf', $value);
    }

    public function sendRequest($data)
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
            !empty($data) ? json_encode($data) : null
        );

        $httpRequest
            ->setHeader('Content-Type', 'application/json;charset=UTF-8')
            ->setHeader('Accept', 'application/json')
            ->setHeader('Authorization', $this->getSecretApiKey());

        return $httpRequest->send();
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

    public function getEndpoint()
    {
        if ($this->getTestMode()) {
            return $this->testEndpoint;
        }

        return $this->liveEndpoint;
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

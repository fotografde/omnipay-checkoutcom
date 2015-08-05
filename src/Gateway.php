<?php

namespace Omnipay\CheckoutCom;

use Omnipay\Common\AbstractGateway;

/**
 * NetBanx Class
 */
class Gateway extends AbstractGateway
{
    /**
     * Get name of the gateway
     *
     * @return string
     */
    public function getName()
    {
        return 'CheckoutCom';
    }

    public function getDefaultParameters()
    {
        return array(
            'secretApiKey' => '',
            'publicApiKey' => '',
        );
    }

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

    /**
     * Create a new charge.
     *
     * @param array An array of options
     * @return \Omnipay\ResponseInterface
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\CheckoutCom\Message\AuthorizeRequest', $parameters);
    }

    /**
     * Create a new charge.
     *
     * @param array An array of options
     * @return \Omnipay\ResponseInterface
     */
    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\CheckoutCom\Message\CaptureRequest', $parameters);
    }
}

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

    /**
     * Get default parameters
     *
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'merchantId' => '',
            'merchantPassword' => '',
            'testMode' => false,
        );
    }

    /**
     * Create a new charge.
     *
     * @param array An array of options
     * @return \Omnipay\ResponseInterface
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\CheckoutCom\Message\PurchaseRequest', $parameters);
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
     * Setter for Merchant Id
     *
     * @param string $value
     * @return $this
     */
    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * Getter for Merchant Id
     *
     * @return string
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * Setter for Merchant Password
     *
     * @param string $value
     * @return $this
     */
    public function setMerchantPassword($value)
    {
        return $this->setParameter('merchantPassword', $value);
    }

    /**
     * Getter for Merchant Password
     *
     * @return string
     */
    public function getMerchantPassword()
    {
        return $this->getParameter('merchantPassword');
    }

}

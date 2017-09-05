<?php

namespace Omnipay\CheckoutCom;

use Omnipay\Common\AbstractGateway;

/**
 * CheckoutCom Class
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
            'testMode' => false,
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

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\CheckoutCom\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\CheckoutCom\Message\CompletePurchaseRequest', $parameters);
    }

    public function cardTokenPurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\CheckoutCom\Message\CardTokenPurchaseRequest', $parameters);
    }
}

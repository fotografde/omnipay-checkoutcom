<?php
/**
 * CheckoutCom Response
 */

namespace Omnipay\CheckoutCom\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * CheckoutCom Response
 *
 * This is the response class for all CheckoutCom requests.
 *
 * @see \Omnipay\CheckoutCom\Gateway
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    protected $redirectEndpoint = null;

    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectUrl()
    {
        if ($this->isRedirect()) {
            return $this->redirectEndpoint . '/' . $this->getTransactionReference();
        }
    }

    public function getRedirectData()
    {
        return $this->getData();
    }
}

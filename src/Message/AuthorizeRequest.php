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
 * Example:
 *
 * <code>
 *   // Create a gateway for the CheckoutCom Gateway
 *   // (routes to GatewayFactory::create)
 *   $gateway = Omnipay::create('CheckoutCom');
 *
 *   // Initialise the gateway
 *   $gateway->initialize(array(
 *       'apiKey' => 'MyApiKey',
 *   ));
 *
 *   // Create a credit card object
 *   // This card can be used for testing.
 *   $card = new CreditCard(array(
 *               'firstName'    => 'Example',
 *               'lastName'     => 'Customer',
 *               'number'       => '4242424242424242',
 *               'expiryMonth'  => '01',
 *               'expiryYear'   => '2020',
 *               'cvv'          => '123',
 *               'email'                 => 'customer@example.com',
 *               'billingAddress1'       => '1 Scrubby Creek Road',
 *               'billingCountry'        => 'AU',
 *               'billingCity'           => 'Scrubby Creek',
 *               'billingPostcode'       => '4999',
 *               'billingState'          => 'QLD',
 *   ));
 *
 *   // Do an authorize transaction on the gateway
 *   $transaction = $gateway->authorize(array(
 *       'amount'                   => '10.00',
 *       'currency'                 => 'USD',
 *       'description'              => 'This is a test authorize transaction.',
 *       'card'                     => $card,
 *   ));
 *   $response = $transaction->send();
 *   if ($response->isSuccessful()) {
 *       echo "Authorize transaction was successful!\n";
 *       $sale_id = $response->getTransactionReference();
 *       echo "Transaction reference = " . $sale_id . "\n";
 *   }
 * </code>
 *
 * @see \Omnipay\CheckoutCom\Gateway
 * @link https://stripe.com/docs/api#charges
 */
class AuthorizeRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount', 'currency');

        $data = array();
        $data['value'] = $this->getAmountInteger();
        $data['currency'] = strtoupper($this->getCurrency());

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

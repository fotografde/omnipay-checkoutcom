<?php

namespace Omnipay\CheckoutCom\Message;

use Omnipay\Common\CreditCard;

/**
 * NetBanx Authorize Request
 */
class AuthorizeRequest extends AbstractRequest
{
    const MODE_AUTH = 'ccAuthorize';
    const MODE_STORED_DATA_AUTH = 'ccStoredDataAuthorize';

    /**
     * Method
     *
     * @var string
     */
    protected $txnMode;

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if ($this->getTransactionReference() || $this->getCardReference()) {
            $this->txnMode = $this->getStoredDataMode();
            $this->validate('amount');
        } else {
            $this->txnMode = $this->getBasicMode();
            $this->validate('amount', 'card');
            $this->getCard()->validate();
        }

        $data = $this->getBaseData();
        $data['txnRequest'] = $this->getXmlString();

        return $data;
    }

    /**
     * Get XML string
     *
     * @return string
     */
    protected function getXmlString()
    {

        

        $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>
                <request />";

        $sxml = new \SimpleXMLElement($xml);

        $sxml->addChild('account_identifier', '');

        $sxml->addChild('merchantid', $this->getMerchantId());
        $sxml->addChild('password', $this->getMerchantPassword());
        $sxml->addChild('action', 1);
        $sxml->addChild('trackid', '1122-001');

        $sxml->addChild('bill_currencycode', $this->getCurrency());
        $sxml->addChild('bill_cardholder', 'CASH CUSTOMER');
        $sxml->addChild('bill_cc_type', 'VISA');
        $sxml->addChild('bill_cc_brand', 'MC');
        $sxml->addChild('bill_cc', '4543474002249996');
        $sxml->addChild('bill_expmonth', '06');
        $sxml->addChild('bill_expyear', '2017');
        $sxml->addChild('bill_cvv2', '956');
        $sxml->addChild('bill_address', 'Billing Address');
        $sxml->addChild('bill_address2', 'Billing Address 2');
        $sxml->addChild('bill_postal', 'Billing Postal');
        $sxml->addChild('bill_city', 'Billing city');
        $sxml->addChild('bill_state', 'Billing state');
        $sxml->addChild('bill_email', 'omkar61422@gmail.com');
        $sxml->addChild('bill_country', 'USA');
        $sxml->addChild('bill_amount', $this->getAmount());
        $sxml->addChild('bill_phone', '44-12312331312');
        $sxml->addChild('bill_fax', '44-12312331312');
        $sxml->addChild('bill_customerip', '123.123.123.200');
        $sxml->addChild('bill_merchantip', '192.168.5.5');

        $sxml->addChild('ship_address', 'Shipping address');
        $sxml->addChild('ship_email', 'email@shipping.com');
        $sxml->addChild('ship_postal', 'Shipping Postal Code');
        $sxml->addChild('ship_address2', 'Shipping Address 2');
        $sxml->addChild('ship_type', 'FEDEX');
        $sxml->addChild('ship_city', 'Shipping City');
        $sxml->addChild('ship_state', 'Shipping State');
        $sxml->addChild('ship_phone', '44-12312331312');
        $sxml->addChild('ship_country', 'USA');
        $sxml->addChild('ship_fax', '44-12312331312');

        $sxml->addChild('udf1', '');
        $sxml->addChild('udf2', '');
        $sxml->addChild('udf3', '');
        $sxml->addChild('udf4', '');
        $sxml->addChild('udf5', '');

        $sxml->addChild('merchantcustomerid', '');
        $sxml->addChild('product_desc', '');
        $sxml->addChild('product_quantity', '');
        $sxml->addChild('product_unitcost', '');


//        $sxml->addChild('merchantRefNum', $this->getCustomerId() ?: 'ref-num - ' . time());

        if ($this->getTransactionReference() || $this->getCardReference()) {
            $sxml->addChild('confirmationNumber', $this->getTransactionReference() ?: $this->getCardReference());
            $sxml->addChild('amount', $this->getAmount());
        } else {
            /** @var $card CreditCard */
            $card = $this->getCard();

            $sxml->addChild('amount', $this->getAmount());

            $cardChild = $sxml->addChild('card');

            $cardChild->addChild('cardNum', $card->getNumber());

            $cardExpiry = $cardChild->addChild('cardExpiry');
            $cardExpiry->addChild('month', $card->getExpiryDate('m'));
            $cardExpiry->addChild('year', $card->getExpiryDate('Y'));

            $cardChild->addChild('cardType', $this->translateCardType($card->getBrand()));
            $cardChild->addChild('cvdIndicator', '1');
            $cardChild->addChild('cvd', $card->getCvv());

            $billingDetails = $sxml->addChild('billingDetails');

            $billingDetails->addChild('cardPayMethod', 'WEB');
            $billingDetails->addChild('firstName', $card->getBillingFirstName());
            $billingDetails->addChild('lastName', $card->getBillingLastName());
            $billingDetails->addChild('street', $card->getBillingAddress1());
            $billingDetails->addChild('street2', $card->getBillingAddress2());
            $billingDetails->addChild('city', $card->getBillingCity());
            $billingDetails->addChild('state', $card->getBillingState());
            $billingDetails->addChild('country', $card->getBillingCountry());
            $billingDetails->addChild('zip', $card->getBillingPostcode());
            $billingDetails->addChild('phone', $card->getBillingPhone());
            $billingDetails->addChild('email', $card->getEmail());

            $shippingDetails = $sxml->addChild('shippingDetails');

            $shippingDetails->addChild('firstName', $card->getShippingFirstName());
            $shippingDetails->addChild('lastName', $card->getShippingLastName());
            $shippingDetails->addChild('street', $card->getShippingAddress1());
            $shippingDetails->addChild('street2', $card->getShippingAddress2());
            $shippingDetails->addChild('city', $card->getShippingCity());
            $shippingDetails->addChild('state', $card->getShippingState());
            $shippingDetails->addChild('country', $card->getShippingCountry());
            $shippingDetails->addChild('zip', $card->getShippingPostcode());
            $shippingDetails->addChild('phone', $card->getShippingPhone());
            $shippingDetails->addChild('email', $card->getEmail());
        }

        return $sxml->asXML();
    }

    /**
     * Get Stored Data Mode
     *
     * @return string
     */
    protected function getStoredDataMode()
    {
        return self::MODE_STORED_DATA_AUTH;
    }

    /**
     * Get Stored Data Mode
     *
     * @return string
     */
    protected function getBasicMode()
    {
        return self::MODE_AUTH;
    }
}

<?php

namespace Omnipay\CheckoutCom;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase(array('amount' => '10.00'));

        $this->assertInstanceOf('Omnipay\CheckoutCom\Message\PurchaseRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testCompletePurchase()
    {
        $request = $this->gateway->completePurchase(array('amount' => '10.00'));

        $this->assertInstanceOf('Omnipay\CheckoutCom\Message\CompletePurchaseRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testCardTokenPurchase()
    {
        $request = $this->gateway->cardTokenPurchase(array('amount' => '10.00'));

        $this->assertInstanceOf('Omnipay\CheckoutCom\Message\CardTokenPurchaseRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }
}

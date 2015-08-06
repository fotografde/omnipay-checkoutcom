<?php

namespace Omnipay\CheckoutCom\Message;

use Omnipay\Tests\TestCase;

class CompletePurchaseRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setTransactionReference('foo');
    }

    public function testEndpoint()
    {
        $this->assertSame('https://api2.checkout.com/v2/charges/foo', $this->request->getEndpoint());
    }

    public function testAmount()
    {
        // defualt is no amount
        $this->assertArrayNotHasKey('value', $this->request->getData());

        $this->request->setAmount('10.00');

        $data = $this->request->getData();
        $this->assertSame(1000, $data['value']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('CompletePurchaseSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('charge_B41BEAAC175U76BD3EE1', $response->getTransactionReference());
        $this->assertNull($response->getMessage());
    }

    public function testSendError()
    {
        $this->setMockHttpResponse('CompletePurchaseFailure.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getCardReference());
        $this->assertSame('Charge ch_1lvgjcQgrNWUuZ has already been captured.', $response->getMessage());
    }
}

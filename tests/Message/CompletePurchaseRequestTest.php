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
        // default is no amount
        $this->assertNull($this->request->getData());

        $this->request->setAmount('10.00');

        // Changing the Amount should not have any impact. -> CompletePurchaseRequest is a GET with no content
        $this->assertNull($this->request->getData());
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
        $this->assertSame('70000: Validation error', $response->getMessage());
    }
}

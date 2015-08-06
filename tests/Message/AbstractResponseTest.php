<?php

namespace Omnipay\CheckoutCom\Message;

use Omnipay\Tests\TestCase;

class AbstractResponseTest extends TestCase
{
    public function testPurchaseSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('CompletePurchaseSuccess.txt');
        $response = new AbstractResponse($this->getMockRequest(), $httpResponse->json());

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('charge_B41BEAAC175U76BD3EE1', $response->getTransactionReference());
        $this->assertNull($response->getMessage());
    }

//    public function testPurchaseFailure()
//    {
//        $httpResponse = $this->getMockHttpResponse('CompletePurchaseFailure.txt');
//        $response = new AbstractResponse($this->getMockRequest(), $httpResponse->json());
//
//        $this->assertFalse($response->isSuccessful());
//        $this->assertFalse($response->isRedirect());
//        $this->assertNull($response->getTransactionReference());
//        $this->assertNull($response->getCardReference());
//        $this->assertSame('Your card was declined', $response->getMessage());
//    }
}

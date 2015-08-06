<?php

namespace Omnipay\CheckoutCom\Message;

use Omnipay\Tests\TestCase;

class PurchaseResponseTest extends TestCase
{
    public function testPurchaseSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('PurchaseSuccess.txt');
        $response = new PurchaseResponse($this->getMockRequest(), $httpResponse->json());

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertSame('pay_tok_5a010daa-4a30-4171-a8e9-8ae0c6de1c68', $response->getTransactionReference());
        $this->assertNull($response->getMessage());

        $this->assertSame('GET', $response->getRedirectMethod());

        $expected = array(
            'id' => 'pay_tok_5a010daa-4a30-4171-a8e9-8ae0c6de1c68',
            'liveMode' => true
        );
        $this->assertSame($expected, $response->getRedirectData());

        $this->assertSame('placeholder', $response->getRedirectUrl());

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

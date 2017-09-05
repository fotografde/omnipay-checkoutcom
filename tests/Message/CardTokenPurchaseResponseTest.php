<?php

namespace Omnipay\CheckoutCom\Message;

use Omnipay\Tests\TestCase;

class CardTokenPurchaseResponseTest extends TestCase
{
    public function testPurchaseSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('CardTokenPurchaseSuccess.txt');
        $response = new CardTokenPurchaseResponse($this->getMockRequest(), $httpResponse->json());

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('charge_test_DD0BF9EC548R752B79E2', $response->getTransactionReference());
        $this->assertNull($response->getMessage());
    }

    public function testPurchaseFailure()
    {
        $httpResponse = $this->getMockHttpResponse('CardTokenPurchaseFailure.txt');
        $response = new CardTokenPurchaseResponse($this->getMockRequest(), $httpResponse->json());

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('charge_test_EE0E09FC548L752B6C12', $response->getTransactionReference());
        $this->assertSame('20087: Bad Track Data', $response->getMessage());
    }

    public function testPurchaseFailureValidation()
    {
        $httpResponse = $this->getMockHttpResponse('CardTokenPurchaseFailureValidation.txt');
        $response = new CardTokenPurchaseResponse($this->getMockRequest(), $httpResponse->json());

        $this->assertFalse($response->isSuccessful());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame('70000: Validation error', $response->getMessage());
    }
}

<?php

namespace Omnipay\CheckoutCom\Message;

use Omnipay\Tests\TestCase;

class CardTokenPurchaseRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new CardTokenPurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'amount' => '12.00',
                'currency' => 'uSd',
                'description' => 'Order #42',
                'email' => 'customer@test.com',
                'metadata' => array(
                    'foo' => 'bar',
                ),
                'udf' => array(
                    'first' => 'lorem',
                    'second' => 'ipsum'
                )
            )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame(1200, $data['value']);
        $this->assertSame('USD', $data['currency']);
        $this->assertSame('Order #42', $data['description']);
        $this->assertSame(array('foo' => 'bar'), $data['metadata']);
        $this->assertSame('lorem', $data['udf1']);
        $this->assertSame('ipsum', $data['udf2']);
        $this->assertSame('customer@test.com', $data['email']);

    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('CardTokenPurchaseSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('charge_test_DD0BF9EC548R752B79E2', $response->getTransactionReference());
        $this->assertNull($response->getMessage());
    }

    public function testSendErrorValidation()
    {
        $this->setMockHttpResponse('CardTokenPurchaseFailureValidation.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame('70000: Validation error', $response->getMessage());
    }

    public function testSendError()
    {
        $this->setMockHttpResponse('CardTokenPurchaseFailure.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('charge_test_EE0E09FC548L752B6C12', $response->getTransactionReference());
        $this->assertSame('20087: Bad Track Data', $response->getMessage());
    }
}

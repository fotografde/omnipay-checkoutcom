<?php

namespace Omnipay\CheckoutCom\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'amount' => '12.00',
                'currency' => 'uSd',
                'description' => 'Order #42',
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

    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertSame('pay_tok_5a010daa-4a30-4171-a8e9-8ae0c6de1c68', $response->getTransactionReference());
        $this->assertNull($response->getMessage());
    }

    public function testSendError()
    {
        $this->setMockHttpResponse('PurchaseFailure.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame('70000: Validation error', $response->getMessage());
    }
}

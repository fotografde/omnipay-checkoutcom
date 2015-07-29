<?php

namespace Omnipay\Checkoutcom;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testAuthorize()
    {
        $request = $this->gateway->authorize(array('amount' => '10.00'));

        $this->assertInstanceOf('Omnipay\Checkoutcom\Message\AuthorizeRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testCapture()
    {
        $request = $this->gateway->capture(array('amount' => '10.00'));

        $this->assertInstanceOf('Omnipay\Checkoutcom\Message\CaptureRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase(array('amount' => '10.00'));

        $this->assertInstanceOf('Omnipay\Checkoutcom\Message\PurchaseRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testRefund()
    {
        $request = $this->gateway->refund(array('amount' => '10.00'));

        $this->assertInstanceOf('Omnipay\Checkoutcom\Message\RefundRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testVoid()
    {
        $request = $this->gateway->void();

        $this->assertInstanceOf('Omnipay\Checkoutcom\Message\VoidRequest', $request);
    }

    public function testFetchTransaction()
    {
        $request = $this->gateway->fetchTransaction(array());

        $this->assertInstanceOf('Omnipay\Checkoutcom\Message\FetchTransactionRequest', $request);
    }

    public function testFetchToken()
    {
        $request = $this->gateway->fetchToken(array());

        $this->assertInstanceOf('Omnipay\Checkoutcom\Message\FetchTokenRequest', $request);
    }

    public function testCreateCard()
    {
        $request = $this->gateway->createCard(array('description' => 'foo'));

        $this->assertInstanceOf('Omnipay\Checkoutcom\Message\CreateCardRequest', $request);
        $this->assertSame('foo', $request->getDescription());
    }

    public function testUpdateCard()
    {
        $request = $this->gateway->updateCard(array('cardReference' => 'cus_1MZSEtqSghKx99'));

        $this->assertInstanceOf('Omnipay\Checkoutcom\Message\UpdateCardRequest', $request);
        $this->assertSame('cus_1MZSEtqSghKx99', $request->getCardReference());
    }

    public function testDeleteCard()
    {
        $request = $this->gateway->deleteCard(array('cardReference' => 'cus_1MZSEtqSghKx99'));

        $this->assertInstanceOf('Omnipay\Checkoutcom\Message\DeleteCardRequest', $request);
        $this->assertSame('cus_1MZSEtqSghKx99', $request->getCardReference());
    }
}

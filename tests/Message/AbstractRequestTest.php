<?php

namespace Omnipay\CheckoutCom\Message;

use Mockery as m;
use Omnipay\Tests\TestCase;

class AbstractRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = m::mock('\Omnipay\CheckoutCom\Message\AbstractRequest')->makePartial();
        $this->request->initialize();
    }

    public function testUdf()
    {
        $this->assertSame($this->request, $this->request->setUdf(array('foo' => 'bar')));
        $this->assertSame(array('foo' => 'bar'), $this->request->getUdf());
        $this->assertSame(array(0 => 'bar'), $this->request->getUdfValues());
    }

    public function testMetadata()
    {
        $this->assertSame($this->request, $this->request->setMetadata(array('foo' => 'bar')));
        $this->assertSame(array('foo' => 'bar'), $this->request->getMetadata());

    }
}

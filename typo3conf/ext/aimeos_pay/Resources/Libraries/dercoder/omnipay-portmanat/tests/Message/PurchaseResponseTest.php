<?php
namespace Omnipay\Portmanat\Message;

use Omnipay\Tests\TestCase;

class PurchaseResponseTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'partnerId' => '12345',
            'serviceId' => '67890',
            'securityKey' => 'oJ2rHLBVSbD5iGfT',
            'method' => 'code',
            'transactionId' => '1234567890',
            'amount' => '14.65',
            'currency' => 'AZN'
        ));
    }

    public function testSuccess()
    {
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame('POST', $response->getRedirectMethod());
        $this->assertSame('https://www.portmanat.az/checkout', $response->getRedirectUrl());
        $this->assertSame(array(
            's_id' => '67890',
            'o_id' => '1234567890',
            'method' => 'code',
            'amount' => '14.65'
        ), $response->getRedirectData());
    }
}

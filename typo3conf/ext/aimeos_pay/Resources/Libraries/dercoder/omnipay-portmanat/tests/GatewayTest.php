<?php
namespace Omnipay\Portmanat;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setPartnerId('12345');
        $this->gateway->setServiceId('67890');
        $this->gateway->setSecurityKey('oJ2rHLBVSbD5iGfT');
        $this->gateway->setTestMode(true);
    }

    public function testGateway()
    {
        $this->assertSame('12345', $this->gateway->getPartnerId());
        $this->assertSame('67890', $this->gateway->getServiceId());
        $this->assertSame('oJ2rHLBVSbD5iGfT', $this->gateway->getSecurityKey());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase(array(
            'method' => 'ACCOUNT',
            'transactionId' => '1234567890',
            'amount' => '14.65',
            'currency' => 'EUR'
        ));

        $this->assertSame('account', $request->getMethod());
        $this->assertSame('1234567890', $request->getTransactionId());
        $this->assertSame('14.65', $request->getAmount());
        $this->assertSame('EUR', $request->getCurrency());
    }

    public function testCompletePurchase()
    {
        $request = $this->gateway->completePurchase(array(
            'transactionId' => '9087654321',
            'amount' => '12.43',
            'currency' => 'EUR'
        ));

        $this->assertSame('9087654321', $request->getTransactionId());
        $this->assertSame('12.43', $request->getAmount());
        $this->assertSame('EUR', $request->getCurrency());
    }
}

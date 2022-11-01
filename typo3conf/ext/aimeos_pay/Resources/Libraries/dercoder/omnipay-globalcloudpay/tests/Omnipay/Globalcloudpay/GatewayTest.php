<?php
namespace Omnipay\Globalcloudpay;

use Omnipay\Tests\GatewayTestCase;
use Omnipay\Common\Issuer;
use Omnipay\Common\CreditCard;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setMerNo('20777');
        $this->gateway->setGatewayNo('20777001');
        $this->gateway->setSignKey('y36aX5D');
    }

    public function testPurchase()
    {
        $this->assertSame('20777', $this->gateway->getMerNo());
        $this->assertSame('20777001', $this->gateway->getGatewayNo());
        $this->assertSame('y36aX5D', $this->gateway->getSignKey());

        $request = $this->gateway->purchase(array(
            'amount' => '14.65',
            'currency' => 'EUR',
            'transactionId' => 'TX9997888',
            'clientIp' => '10.32.46.23',
            'returnUrl' => 'https://www.domain.com/result/',
            'csid' => 'DE&@DE&@MOZILLA&@&@NETSCAPE&',
            'issuer' => new Issuer(null, 'Bank of Europe'),
            'card' => new CreditCard(array(
                'firstName' => 'Example',
                'lastName' => 'User',
                'email' => 'example.user@domain.com',
                'number' => '4111111111111111',
                'expiryMonth' => '12',
                'expiryYear' => '2116',
                'cvv' => '123'
            )),
        ));

        $this->assertSame('20777', $request->getMerNo());
        $this->assertSame('20777001', $request->getGatewayNo());
        $this->assertSame('y36aX5D', $request->getSignKey());
        $this->assertSame('DE&@DE&@MOZILLA&@&@NETSCAPE&', $request->getCsid());
    }
}

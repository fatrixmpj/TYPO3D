<?php
namespace Omnipay\Globalcloudpay\Message;

use Omnipay\Tests\TestCase;
use Omnipay\Common\Issuer;
use Omnipay\Common\CreditCard;

class PurchaseRequestTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'merNo'                     => '20777',
            'gatewayNo'                 => '20777001',
            'signKey'                   => 'y36aX5D',
            'transactionId'             => 'TX4567890',
            'clientIp'                  => '10.32.46.23',
            'returnUrl'                 => 'https://www.domain.com/result/',
            'csid'                      => 'EN&@EN&@MOZILLA&@&@NETSCAPE&',
            'description'               => 'Free Text Description',
            'amount'                    => '12.34',
            'currency'                  => 'EUR',
            'issuer'                    => new Issuer(null, 'Bank of Europe'),
            'card'                      => new CreditCard(array(
                'firstName'                 => 'Example',
                'lastName'                  => 'User',
                'billingCountry'            => 'US',
                'billingState'              => 'Alaska',
                'billingPostcode'           => '47544',
                'billingCity'               => 'Nome',
                'billingAddress1'           => 'Earlington Rd. 123',
                'email'                     => 'example.user@domain.com',
                'phone'                     => '+1 543 6653 456',
                'number'                    => '4111111111111111',
                'expiryMonth'               => '12',
                'expiryYear'                => '2116',
                'cvv'                       => '123',
            )),
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('20777', $data['merNo']);
        $this->assertSame('20777001', $data['gatewayNo']);
        $this->assertSame('TX4567890', $data['orderNo']);
        $this->assertSame('EUR', $data['orderCurrency']);
        $this->assertSame('12.34', $data['orderAmount']);
        $this->assertSame('Example', $data['firstName']);
        $this->assertSame('User', $data['lastName']);
        $this->assertSame('4111111111111111', $data['cardNo']);
        $this->assertSame('2116', $data['cardExpireYear']);
        $this->assertSame('12', $data['cardExpireMonth']);
        $this->assertSame('123', $data['cardSecurityCode']);
        $this->assertSame('example.user@domain.com', $data['email']);
        $this->assertSame('Bank of Europe', $data['issuingBank']);
        $this->assertSame('10.32.46.23', $data['ip']);
        $this->assertSame('+1 543 6653 456', $data['phone']);
        $this->assertSame('US', $data['country']);
        $this->assertSame('Alaska', $data['state']);
        $this->assertSame('Nome', $data['city']);
        $this->assertSame('Earlington Rd. 123', $data['address']);
        $this->assertSame('Free Text Description', $data['remark']);
        $this->assertSame('https://www.domain.com/result/', $data['returnUrl']);
        $this->assertSame('EN&@EN&@MOZILLA&@&@NETSCAPE&', $data['csid']);
        $this->assertSame('212ec369b989e1ecbe41e115c14b1c81be7472895713815872006b1b7d676684', $data['signInfo']);
    }

    public function testEndpoint()
    {
        $this->assertStringEndsWith('/TPInterface', $this->request->getEndpoint());
    }
}

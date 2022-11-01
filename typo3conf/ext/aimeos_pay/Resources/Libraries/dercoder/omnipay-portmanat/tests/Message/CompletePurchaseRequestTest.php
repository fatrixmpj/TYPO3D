<?php
namespace Omnipay\Portmanat\Message;

use Omnipay\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class CompletePurchaseRequestTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();

        $httpRequest = new HttpRequest(array(), array(
            'o_id' => '1234567890',
            'transaction' => 'TX9997888',
            'method' => 'CODE',
            'amount' => '14.65',
            'test' => '1',
            'hash' => 'CE76828063B3A2E3793A23C21B603E93'
        ));

        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $httpRequest);
        $this->request->initialize(array(
            'partnerId' => '12345',
            'serviceId' => '67890',
            'securityKey' => 'oJ2rHLBVSbD5iGfT',
            'testMode' => true
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('1234567890', $data['o_id']);
        $this->assertSame('TX9997888', $data['transaction']);
        $this->assertSame('CODE', $data['method']);
        $this->assertSame('14.65', $data['amount']);
        $this->assertSame('1', $data['test']);
        $this->assertSame('CE76828063B3A2E3793A23C21B603E93', $data['hash']);
    }

    public function testSendData()
    {
        $data = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertSame('Omnipay\Portmanat\Message\CompletePurchaseResponse', get_class($response));
    }
}

<?php
namespace Omnipay\Portmanat\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
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

    public function testException()
    {
        $this->request->setCurrency('EUR');

        try {
            $this->request->getData();
        } catch (\Exception $e) {
            $this->assertEquals('Omnipay\Common\Exception\InvalidRequestException', get_class($e));
        }
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('67890', $data['s_id']);
        $this->assertSame('1234567890', $data['o_id']);
        $this->assertSame('code', $data['method']);
        $this->assertSame('14.65', $data['amount']);
    }

    public function testSendData()
    {
        $data = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertSame('Omnipay\Portmanat\Message\PurchaseResponse', get_class($response));
    }
}

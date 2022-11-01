<?php
namespace Omnipay\Globalcloudpay\Message;

use Omnipay\Tests\TestCase;

class PurchaseResponseTest extends TestCase
{
    public function testSuccess()
    {
        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array(
            'signKey' => 'y36aX5D'
        ));

        $httpResponse = $this->getMockHttpResponse('PurchaseSuccess.txt');
        $response = new PurchaseResponse($request, $httpResponse->xml());

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(1, $response->getCode());
        $this->assertSame('Transaction succeeded', $response->getMessage());
        $this->assertSame('Free Text Description', $response->getDescription());
        $this->assertSame('12.34', $response->getAmount());
        $this->assertSame('USD', $response->getCurrency());
        $this->assertSame('TX4567890', $response->getTransactionId());
        $this->assertSame('T2015040718570911195094', $response->getTransactionReference());
        $this->assertSame('|||0.0|0.0|||||10.32.46.23|US|', $response->getRiskInfo());
        $this->assertSame('7A2214CC6D72B38567F031BC3C4705CCB9CAA0F70EA9C2CBDB8BDD07CF8765DB', $response->getSignInfo());
        $this->assertSame('7a2214cc6d72b38567f031bc3c4705ccb9caa0f70ea9c2cbdb8bdd07cf8765db', $response->getRealSignInfo());
    }

    public function testFailure()
    {
        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array(
            'signKey' => 'y36aX5D'
        ));

        $httpResponse = $this->getMockHttpResponse('PurchaseFailure.txt');
        $response = new PurchaseResponse($request, $httpResponse->xml());

        $this->assertFalse($response->isSuccessful());
        $this->assertSame(0, $response->getCode());
        $this->assertSame('Duplicate Order', $response->getMessage());
        $this->assertSame('Free Text Description', $response->getDescription());
        $this->assertSame('12.34', $response->getAmount());
        $this->assertSame('USD', $response->getCurrency());
        $this->assertSame('TX4567890', $response->getTransactionId());
        $this->assertSame('T2015040720092921268614', $response->getTransactionReference());
        $this->assertSame('|||0.0|0.0|||||10.32.46.23|US|', $response->getRiskInfo());
        $this->assertSame('8F8E9FD19E738822664420E611A5BA540C163167A5BE2ABAE25AF76F0B3B2F46', $response->getSignInfo());
        $this->assertSame('8f8e9fd19e738822664420e611a5ba540c163167a5be2abae25af76f0b3b2f46', $response->getRealSignInfo());
    }
}

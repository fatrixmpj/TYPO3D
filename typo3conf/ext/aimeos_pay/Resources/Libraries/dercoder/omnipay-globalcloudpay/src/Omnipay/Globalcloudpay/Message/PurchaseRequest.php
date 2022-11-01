<?php
namespace Omnipay\Globalcloudpay\Message;

/**
 * Globalcloudpay Purchase Request
 *
 * @author Alexander Fedra <contact@dercoder.at>
 * @copyright 2015 DerCoder
 * @license http://opensource.org/licenses/mit-license.php MIT
 * @version 1.5 Globalcloudpay API Specification
 */
class PurchaseRequest extends AbstractRequest
{
    protected $liveEndpoint = 'https://online-safest.com/TPInterface';
    protected $testEndpoint = 'https://online-safest.com/TestTPInterface';

    /**
     * Get the CSID
     *
     * Capture this value through: https://online-safest.com/pub/csid.js
     *
     * @return string csid
     */
    public function getCsid()
    {
        return $this->getParameter('csid');
    }

    /**
     * Set the CSID
     *
     * Capture this value through: https://online-safest.com/pub/csid.js
     *
     * @param  string $value csid
     * @return self
     */
    public function setCsid($value)
    {
        return $this->setParameter('csid', $value);
    }

    /**
     * Get the data for this request.
     *
     * @return array request data
     */
    public function getData()
    {
        $this->validate(
            'merNo',
            'gatewayNo',
            'signKey',
            'transactionId',
            'amount',
            'currency',
            'clientIp',
            'returnUrl',
            'csid'
        );

        $this->getCard()->validate();

        $data = array();
        $data['merNo'] = $this->getMerNo();
        $data['gatewayNo'] = $this->getGatewayNo();
        $data['orderNo'] = $this->getTransactionId();
        $data['orderCurrency'] = $this->getCurrency();
        $data['orderAmount'] = $this->getAmount();
        $data['firstName'] = $this->getCard()->getFirstName();
        $data['lastName'] = $this->getCard()->getLastName();
        $data['cardNo'] = $this->getCard()->getNumber();
        $data['cardExpireMonth'] = $this->getCard()->getExpiryDate('m');
        $data['cardExpireYear'] = $this->getCard()->getExpiryDate('Y');
        $data['cardSecurityCode'] = $this->getCard()->getCvv();
        $data['issuingBank'] = $this->getIssuer()->getName();
        $data['email'] = $this->getCard()->getEmail();
        $data['ip'] = $this->getClientIp();
        $data['returnUrl'] = $this->getReturnUrl();
        $data['phone'] = $this->getCard()->getPhone();
        $data['country'] = $this->getCard()->getCountry();
        $data['state'] = $this->getCard()->getState();
        $data['city'] = $this->getCard()->getCity();
        $data['address'] = $this->getCard()->getAddress1();
        $data['zip'] = $this->getCard()->getPostcode();
        $data['remark'] = $this->getDescription();

        $data['signInfo'] = $this->getSignInfo();
        $data['csid'] = $this->getCsid();

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->post($this->getEndpoint(), null, $data)->send();
        return new PurchaseResponse($this, $httpResponse->xml());
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}

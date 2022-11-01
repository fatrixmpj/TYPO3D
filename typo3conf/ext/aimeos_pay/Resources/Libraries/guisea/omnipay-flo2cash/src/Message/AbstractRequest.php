<?php

namespace Omnipay\Flo2cash\Message;

use DOMDocument;
use Guzzle\Http\ClientInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use SimpleXMLElement;

use Omnipay\Flo2cash;

/**
 * Flo2cash Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $namespace = "http://www.flo2cash.co.nz/webservices/paymentwebservice";

    const LIVE_ENDPOINT = 'https://secure.flo2cash.co.nz/ws/paymentws.asmx';
    const TEST_ENDPOINT = 'https://sandbox.flo2cash.com/ws/paymentws.asmx';

    const VERSION = '2.1.1';


    public function sendData($data)
    {
        $transactionType = $data['Transaction'];
        $request = $data['Data'];

        $document = new DOMDocument('1.0', 'UTF-8');
        $envelope = $document->appendChild(
            $document->createElementNS(
                'http://schemas.xmlsoap.org/soap/envelope/',
                'soap:Envelope'
            )
        );
        $envelope->setAttribute('xmlns:xsd', 'http://www.w3.org/2001/XMLSchema-instance');
        $envelope->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema');
        $body = $envelope->appendChild($document->createElement('soap:Body'));
        $body->appendChild($document->importNode(dom_import_simplexml($request), true));
        $document->preserveWhiteSpace = false;
        $document->formatOutput = true;

        $xml = $document->saveXML();
        $xml = trim($xml);
        $headers = array(
            "Content-type" => "text/xml;charset=utf-8",
            "Accept" => "text/xml",
            "Cache-Control" => "no-cache",
            "Pragma" => "no-cache",
            "SOAPAction" => $this->getNamespace() . '/' . $transactionType ,
            "Content-length" => strlen($xml));

        # Catch naughty 500 errors thrown by the gateway
        $this->httpClient->getEventDispatcher()->addListener(
            'request.error',
            function ($event) {
                if ($event['response']->isServerError()) {
                    $event->stopPropagation();
                }
            }
        );

        $httpRequest = $this->httpClient->post(
            $this->getEndpoint(),
            $headers,
            $xml
        );

        $httpResponse = $httpRequest->send();
        
        return $this->response = new Response($this, $httpResponse->getBody());

    }

    /**
     * Set the AccountID.
     *
     * @param number $AccountId Your Flo2Cash AccountId
     */
    public function setAccountId($value)
    {
        $this->setParameter('AccountId', $value);
    }

    /**
     * Get the AccountID.
     *
     * @returns string $AccountId Your Flo2Cash AccountId
     */
    public function getAccountId()
    {
        return $this->getParameter('AccountId');
    }


    /**
     * Set the Particular.
     *
     * @param string $Particular for this charge
     */
    public function setParticular($value)
    {
        $this->setParameter('Particular', $value);
    }

    /**
     * Get the Particular.
     *
     * @returns string $Particular for this charge.
     */
    public function getParticular()
    {
        return $this->getParameter('Particular');
    }


    /**
     * Set the Email.
     *
     * @param string $Email for this charge
     */
    public function setEmail($value)
    {
        $this->setParameter('email', $value);
    }

    /**
     * Get the Email.
     *
     * @returns string $Email for this charge.
     */
    public function getEmail()
    {
        return $this->getParameter('email');
    }

    /**
     * Set the storeCard.
     *
     * @param string $StoreCard for this charge
     */
    public function setStoreCard($value)
    {
        $this->setParameter('storeCard', $value);
    }

    /**
     * Get the storeCard.
     *
     * @returns string $Email for this charge.
     */
    public function getStoreCard()
    {
        return $this->getParameter('storeCard');
    }

    /**
     * Set the username.
     *
     * @param string $username for your Flo2Cash Account
     */
    public function setUsername($username)
    {
        $this->setParameter('username', $username);
    }

    /**
     * Get the username.
     *
     * @returns string $username for your Flo2Cash Account
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * Set the password.
     *
     * @param string $password for your Flo2Cash Account
     */
    public function setPassword($password)
    {
        $this->setParameter('password', $password);
    }

    /**
     * Get the password.
     *
     * @returns string $password for your Flo2Cash Account
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * The reference number that we set on the Klinche side.
     *
     * @param string $merchantReferenceCode
     */
    public function setMerchantReferenceCode($value)
    {
        $this->setParameter('merchantReferenceCode', $value);
    }

    /**
     * return string
     */
    public function getMerchantReferenceCode()
    {
        return $this->getParameter('merchantReferenceCode');
    }
    /**
     * The reference number that we set on the Klinche side.
     *
     * @param string $value
     */
    public function setCardReference($value)
    {
        $this->setParameter('cardReference', $value);
    }

    /**
     * The reference number that we set on the Klinche side.
     *
     * @param string $merchantReferenceCode
     */
    public function getCardReference()
    {
        return $this->getParameter('cardReference');
    }
     /*
     * @param string $transactionKey
     */
    public function setTransactionId($transactionId)
    {
        $this->setParameter('transactionId', $transactionId);
    }

    /**
     * return string
     */
    public function getTransactionId()
    {
        return $this->getParameter('transactionId');
    }

    public function getCardTypes()
    {
        return array(
            'visa' => 'Visa',
            'mastercard' => 'MC',
            'amex' => 'N/A',
            'discover' => 'N/A',
            'diners_club' => 'N/A',
            'carte_blanche' => 'N/A',
            'jcb' => 'N/A',
        );
    }

    public function getCardType()
    {
        $types = $this->getCardTypes();
        $brand = $this->getCard()->getBrand();
        return empty($types[$brand]) ? null : $types[$brand];
    }

    public function getNamespace()
    {
        return "http://www.flo2cash.co.nz/webservices/paymentwebservice";
    }
    public function getEndpoint()
    {
        return $this->getTestMode() ? self::TEST_ENDPOINT : self::LIVE_ENDPOINT;
    }
}

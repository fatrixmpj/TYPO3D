<?php

namespace Omnipay\Cybersource;

use Omnipay\Common\AbstractGateway;

/**
 * Cybersource - Soap Gateway
 */
class CybersourceGateway extends AbstractGateway
{
    /* Default Abstract Gateway methods that need to be overridden */
    public function getName()
    {
        return 'Cybersource - Soap';
    }

    public function getDefaultParameters()
    {
        return array(
            'merchantId' => 'myMerchantId',
            'transactionKey' => 'myTransactionKey',
            'username' => 'myUsername',
        );
    }

    /**
     * @param string $merchantId
     * @return $this
     */
    public function setMerchantId($merchantId)
    {
        $this->setParameter('merchantId', $merchantId);
        return $this;
    }

    /**
     * return string
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->setParameter('username', $username);
        return $this;
    }

    /**
     * return string
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * @param string $transactionKey
     * @return $this
     */
    public function setTransactionKey($transactionKey)
    {
        $this->setParameter('transactionKey', $transactionKey);
        return $this;
    }

    /**
     * return string
     */
    public function getTransactionKey()
    {
        return $this->getParameter('transactionKey');
    }


    /**
     * @param array $parameters
     * @return \Omnipay\Cybersource\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Cybersource\Message\PurchaseRequest', $parameters);
    }
}

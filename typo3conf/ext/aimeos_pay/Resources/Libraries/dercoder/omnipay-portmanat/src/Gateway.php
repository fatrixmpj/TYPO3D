<?php

namespace Omnipay\Portmanat;

use Omnipay\Common\AbstractGateway;

/**
 * Portmanat Gateway.
 *
 * @author    Alexander Fedra <contact@dercoder.at>
 * @copyright 2015 DerCoder
 * @license   http://opensource.org/licenses/mit-license.php MIT
 */
class Gateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Portmanat';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return array(
            'serviceId' => '',
            'testMode' => false,
        );
    }

    /**
     * Get the partner ID.
     *
     * Portmanat partner id.
     *
     * @return string partnerId
     */
    public function getPartnerId()
    {
        return $this->getParameter('partnerId');
    }

    /**
     * Set the partner ID.
     *
     * Portmanat partner id.
     *
     * @param string $value partnerId
     *
     * @return self
     */
    public function setPartnerId($value)
    {
        return $this->setParameter('partnerId', $value);
    }

    /**
     * Get the service ID.
     *
     * Portmanat service id.
     *
     * @return string serviceId
     */
    public function getServiceId()
    {
        return $this->getParameter('serviceId');
    }

    /**
     * Set the service ID.
     *
     * Portmanat service id.
     *
     * @param string $value serviceId
     *
     * @return self
     */
    public function setServiceId($value)
    {
        return $this->setParameter('serviceId', $value);
    }

    /**
     * Get the security key.
     *
     * Portmanat security key for transaction.
     *
     * @return string security key
     */
    public function getSecurityKey()
    {
        return $this->getParameter('securityKey');
    }

    /**
     * Set the security key.
     *
     * Portmanat security key for transaction.
     *
     * @param string $value security key
     *
     * @return self
     */
    public function setSecurityKey($value)
    {
        return $this->setParameter('securityKey', $value);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Portmanat\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Portmanat\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Portmanat\Message\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Portmanat\Message\CompletePurchaseRequest', $parameters);
    }
}

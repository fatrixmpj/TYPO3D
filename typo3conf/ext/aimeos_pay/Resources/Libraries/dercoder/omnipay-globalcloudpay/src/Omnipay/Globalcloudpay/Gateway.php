<?php
namespace Omnipay\Globalcloudpay;

use Omnipay\Common\AbstractGateway;

/**
 * Globalcloudpay Gateway
 *
 * @author Alexander Fedra <contact@dercoder.at>
 * @copyright 2015 DerCoder
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class Gateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Globalcloudpay';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return array(
            'merNo' => '',
            'gatewayNo' => '',
            'signKey' => '',
            'testMode' => false
        );
    }

    /**
     * Get the Merchant No
     *
     * This value is provided by Globalcloudpay is used to authenticate a merchant.
     *
     * @return string merchant no
     */
    public function getMerNo()
    {
        return $this->getParameter('merNo');
    }

    /**
     * Set the Merchant No
     *
     * This value is provided by Globalcloudpay is used to authenticate a merchant.
     *
     * @param  string $value merchant no
     * @return self
     */
    public function setMerNo($value)
    {
        return $this->setParameter('merNo', $value);
    }

    /**
     * Get the Gateway No
     *
     * This value is provided by Globalcloudpay is used to authenticate a merchant.
     *
     * @return string gateway no
     */
    public function getGatewayNo()
    {
        return $this->getParameter('gatewayNo');
    }

    /**
     * Set the Gateway No
     *
     * This value is provided by Globalcloudpay is used to authenticate a merchant.
     *
     * @param  string $value gateway no
     * @return self
     */
    public function setGatewayNo($value)
    {
        return $this->setParameter('gatewayNo', $value);
    }

    /**
     * Get the Sign Key
     *
     * This value is provided by Globalcloudpay is used to sign communication.
     *
     * @return string sign key
     */
    public function getSignKey()
    {
        return $this->getParameter('signKey');
    }

    /**
     * Set the Sign Key
     *
     * This value is provided by Globalcloudpay is used to sign communication.
     *
     * @param  string $value sign key
     * @return self
     */
    public function setSignKey($value)
    {
        return $this->setParameter('signKey', $value);
    }

    /**
     * @param  array                                    $parameters
     * @return \Omnipay\Globalcloudpay\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Globalcloudpay\Message\PurchaseRequest', $parameters);
    }
}

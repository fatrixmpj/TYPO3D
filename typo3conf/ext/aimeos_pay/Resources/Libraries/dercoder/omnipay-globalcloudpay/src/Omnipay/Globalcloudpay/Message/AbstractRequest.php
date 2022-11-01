<?php
namespace Omnipay\Globalcloudpay\Message;

/**
 * Globalcloudpay Abstract Request
 *
 * @author    Alexander Fedra <contact@dercoder.at>
 * @copyright 2015 DerCoder
 * @license   http://opensource.org/licenses/mit-license.php MIT
 * @version   1.5 Globalcloudpay API Specification
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{

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
     * Get the Sign Info
     *
     * The purpose of the checksum is to authenticate the communicating parties
     * and to ensure the integrity of the data they send each other.
     * The checksum is an SHA256 hash.
     * The value is expressed as a string of hexadecimal digits in lowercase
     *
     * @return string checksum
     */
    protected function getSignInfo()
    {
        return hash(
            'sha256',
            $this->getMerNo() .
            $this->getGatewayNo() .
            $this->getTransactionId() .
            $this->getCurrency() .
            $this->getAmount() .
            $this->getCard()->getFirstName() .
            $this->getCard()->getLastName() .
            $this->getCard()->getNumber() .
            $this->getCard()->getExpiryDate('Y') .
            $this->getCard()->getExpiryDate('m') .
            $this->getCard()->getCvv() .
            $this->getCard()->getEmail() .
            $this->getSignKey()
        );
    }
}

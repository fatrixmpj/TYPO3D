<?php

namespace Omnipay\Portmanat\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;

/**
 * Portmanat Complete Purchase Response.
 *
 * @author    Alexander Fedra <contact@dercoder.at>
 * @copyright 2015 DerCoder
 * @license   http://opensource.org/licenses/mit-license.php MIT
 */
class CompletePurchaseResponse extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = $data;

        if ($this->getHash() !== $this->calculateHash()) {
            throw new InvalidResponseException('Invalid hash');
        }

        if ($this->request->getTestMode() !== $this->getTest()) {
            throw new InvalidResponseException('Invalid test mode');
        }
    }

    public function isSuccessful()
    {
        return true;
    }

    public function getTransactionId()
    {
        return $this->data['o_id'];
    }

    public function getTransactionReference()
    {
        return $this->data['transaction'];
    }

    public function getMethod()
    {
        return $this->data['method'];
    }

    public function getAmount()
    {
        return $this->data['amount'];
    }

    public function getTest()
    {
        return (bool) $this->data['test'];
    }

    public function getHash()
    {
        return $this->data['hash'];
    }

    /**
     * Notify Portmanat you received the payment details and wish to confirm the payment.
     */
    public function confirm()
    {
        $this->exitWith('1');
    }

    /**
     * Notify Portmanat you received the payment details but there was an error and the payment
     * cannot be completed. Error should be called rarely, and only when something unforeseen
     * has happened on your server or database.
     */
    public function error()
    {
        $this->exitWith('0');
    }

    /**
     * Exit to ensure no other HTML, headers, comments, or text are included.
     *
     * @param string $result
     *
     * @codeCoverageIgnore
     */
    public function exitWith($result)
    {
        header('Content-Type: text/plain');
        echo $result;
        exit;
    }

    /**
     * Calculate hash to verify transaction details.
     *
     * @return string
     */
    private function calculateHash()
    {
        return strtoupper(md5(
            $this->request->getPartnerId().
            $this->request->getServiceId().
            $this->getTransactionId().
            $this->getTransactionReference().
            $this->request->getSecurityKey()
        ));
    }
}

<?php
namespace Omnipay\Globalcloudpay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;

/**
 * Globalcloudpay Purchase Response
 *
 * @author Alexander Fedra <contact@dercoder.at>
 * @copyright 2015 DerCoder
 * @license http://opensource.org/licenses/mit-license.php MIT
 * @version 1.5 Globalcloudpay API Specification
 */
class PurchaseResponse extends AbstractResponse
{

    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = $data;

        if (strtolower($this->getRealSignInfo()) !== strtolower($this->getSignInfo())) {
            throw new InvalidResponseException('Invalid SignInfo in response. Please verify your signKey');
        }
    }

    public function isSuccessful()
    {
        return $this->getCode() === 1;
    }

    public function getCode()
    {
        return (int) $this->data->orderStatus;
    }

    public function getMessage()
    {
        return (string) $this->data->orderInfo;
    }

    public function getTransactionId()
    {
        return (string) $this->data->orderNo;
    }

    public function getTransactionReference()
    {
        return (string) $this->data->tradeNo;
    }

    public function getMerNo()
    {
        return (string) $this->data->merNo;
    }

    public function getGatewayNo()
    {
        return (string) $this->data->gatewayNo;
    }

    public function getSignInfo()
    {
        return (string) $this->data->signInfo;
    }

    public function getRiskInfo()
    {
        return (string) $this->data->riskInfo;
    }

    public function getCurrency()
    {
        return (string) $this->data->orderCurrency;
    }

    public function getAmount()
    {
        return (string) $this->data->orderAmount;
    }

    public function getDescription()
    {
        return (string) $this->data->remark;
    }

    public function getRealSignInfo()
    {
        return hash(
            'sha256',
            $this->getMerNo() .
            $this->getGatewayNo() .
            $this->getTransactionReference() .
            $this->getTransactionId() .
            $this->getCurrency() .
            $this->getAmount() .
            $this->getCode() .
            $this->getMessage() .
            $this->request->getSignKey()
        );
    }
}

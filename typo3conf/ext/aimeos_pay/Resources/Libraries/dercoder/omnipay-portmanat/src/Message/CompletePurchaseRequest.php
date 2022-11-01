<?php

namespace Omnipay\Portmanat\Message;

/**
 * Portmanat Complete Purchase Request.
 *
 * @author    Alexander Fedra <contact@dercoder.at>
 * @copyright 2015 DerCoder
 * @license   http://opensource.org/licenses/mit-license.php MIT
 */
class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * Get the data for this request.
     *
     * @return array request data
     */
    public function getData()
    {
        $this->validate(
            'partnerId',
            'serviceId',
            'securityKey'
        );

        return array(
            'o_id' => $this->httpRequest->request->get('o_id'),
            'transaction' => $this->httpRequest->request->get('transaction'),
            'method' => $this->httpRequest->request->get('method'),
            'amount' => $this->httpRequest->request->get('amount'),
            'test' => $this->httpRequest->request->get('test'),
            'hash' => $this->httpRequest->request->get('hash'),
        );
    }

    /**
     * Send the request with specified data.
     *
     * @param mixed $data The data to send
     *
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        return new CompletePurchaseResponse($this, $data);
    }
}

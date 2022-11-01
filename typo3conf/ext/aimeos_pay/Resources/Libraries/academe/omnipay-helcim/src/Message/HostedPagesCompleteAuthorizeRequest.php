<?php

namespace Omnipay\Helcim\Message;

use Omnipay\Omnipay;
use Omnipay\Common\Exception\InvalidRequestException;

/**
* Helcim Hosted Page Complete Purchase Request
* Used by both authorize and purchase.
* This is used when Helcin returns the user to the application after successfuly
* submitting credit card details on a HostedPage.
*
* The actions will be to:
*
* - Capture POSTed transaction results.
* - Create a hash of POSTed transaction results.
* - Fetch the transaction from the Helcin-Direct API.
* - Cretae a hash of the transaction from the Helcim-Direct API.
* - Compare the hashes and raise an exception (maybe) if they do not match.
* - Discard most (or all) of the POSTed data and return the Direct transaction details.
*
* The transactionId that we are expecting, needs to be passed in to drive the validation.
* Also override some of the details that are considered to be "locked" by the application,
* for example the ammount, which may be locked to a specific basket. It may also not be
* locked, so the user can adjust the amount being paid, but this depends on the
* application.
*/
class HostedPagesCompleteAuthorizeRequest extends AbstractRequest
{
    protected $action = 'preauth';
    protected $mode = 'hostedpages';

    /**
     * We don't really need this abstract method, but it needs to be concrete.
     */
    public function getPath()
    {
    }

    /**
     * The fields we will check for potential manipultation by the user in the first or final POST.
     * Some of these may ultimately be optional, such as the amount.
     */
    protected static $hash_parameters = array(
        'orderId',
        'response',
        'responseMessage',
        'date',
        'time',
        'type',
        'amount',
        'cardToken',
        'transactionId',
        'avsResponse',
        'cvvResponse',
    );

    /**
     * Additional fields the Hosted Pages form will usually POST back, and may
     * need to be captured at this stage. These fields are not currently available
     * through the direct transaction fetch, so capture them here if needed.
     */
    protected static $additional_fields = array(
        'notice',
        'cardholderName',
        'expiryDate',
    );

    /**
     * Note that some address fields may get truncated when stored or returned, so would
     * fail a hash check. We are discarding the submitted address fields anyway.
     *
     * Some transactions will leave the amount open-ended. We need to take that into account,
     * that we may not know the amount until the form is submitted. However, that amount MUST
     * match the amount stored against the transaction fetched from the API.
     *
     * In effect, we are only trying to validate the orderId so we can get he real data from
     * the service through the API. Additional hash checks are just there to make sure nothing
     * suspicious is being attempted.
     * 
     * In addition, we need to have saved the pre-generated orderId in the session,
     * so we know what orderId we are expecting.
     */

    /**
     * In here we return the result details of the transaction.
     * We also do the hash checking and raise an exception if the hash fails.
     * Once we get past here, the data can be trusted.
     * FIXME: the form may implement custom fields which we will also want to capture.
     * We won't be doing any validation on custom fields. It is not clear whether they are
     * only sent by the form, or stored on the account in the transaction too.
     *
     * @raises Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        // This checks that the transaction ID has been passed in.

        $this->validate('transactionId');

        // Get the transaction for this transaction ID from the Direct API.
        // We start with the gateway and start a Direct request.
        // I don't think there is a way to get to the gateway from here (for
        // cloning), so we create a new one.

        // We MUST have the orderId, generated by the application for the request, to
        // fetch the transaction. No other field is safe, especially the transactionId,
        // whith passes through the user's browser before the application ever sees it.

        if (!$this->getTransactionId()) {
            throw new InvalidRequestException('No transactionId supplied for security checks.');
        }

        // Create a brand new Direct gateway to fetch the transaction.
        // FIXME: this is where we need to look at how this works. Creating a whole
        // new direct driver here is great for production, but awful to test.

        $gateway = Omnipay::create('Helcim_Direct');

        // Reuse our current credentials.
        // This would not be necessary if we could clone the gateway.
        $gateway->setMerchantId($this->getMerchantId());
        $gateway->setGatewayToken($this->getGatewayToken());
        $gateway->setDeveloperMode($this->getDeveloperMode());
        $gateway->setTestMode($this->getTestMode());

        // POST helps avoid caches.
        $gateway->setMethod('POST');

        // Get the transaction
        $fetch_response = $gateway
            ->fetchTransaction(['transactionId' => $this->getTransactionId()])
            ->send();

        // Get the transaction details (from Helcim) as an array.
        $fetch_transaction = $fetch_response->getTransaction();

        // If there is no transaction, then this is an error.
        if (!$fetch_response->isSuccessful()) {
            throw new InvalidRequestException(
                sprintf('Cannot retrieve transaction (%s)', $fetch_response->getErrorMessage())
            );
        }

        // We also need to look at what was posted - the result as claimed
        // by the POST from the user's browser.

        $posted_transaction = $this->httpRequest->request->all();

        // Create the two strings to hash as the security check.
        // In fact, this is hardly even a hash, as we are simply comparing strings.

        $direct_string = '';
        $posted_string = '';

        foreach (static::$hash_parameters as $hash_parameter) {
            if (isset($fetch_transaction[$hash_parameter])) {
                $direct_string .= ':' . $fetch_transaction[$hash_parameter];
            }

            if (isset($posted_transaction[$hash_parameter])) {
                $posted_string .= ':' . $posted_transaction[$hash_parameter];
            }

            // The action ("type" of transaction) won't be included in the POSTed data, so we add it in.
            // For this to work, the application needs to appropriately call CompleteAuthorize()
            // or CompletePurchase().

            if ($hash_parameter === 'type') {
                $posted_string .= ':' . $this->action;
            }
        }

        // Now see if anything has been changed.
        // Thinking about it, we could probably simply discard ALL the data returned by the
        // POST and just retrieve the transaction from the Direct API. But it is good to know
        // if someone is playing games.

        if ($direct_string !== $posted_string) {
            throw new InvalidRequestException('Hashes do not match');
        }

        // Return the Direct API transaction, as we know the user has not been able to
        // manipulate it.

        // Note: the fetched transaction will NOT contain the custom fields, even though they
        // ARE stored on the transactions in the Helcim account. We fix this by grabbing the
        // custom fields and adding them to the returned transaction. Note that they are
        // untrusted - we can not be sure that they match what Helcim was really given.

        // Some additional fields will be POSTed here, and will not be stored anywhere.

        foreach (static::$additional_fields as $extra_posted) {
            if (isset($posted_transaction[$extra_posted])) {
                $fetch_transaction[$extra_posted] = $posted_transaction[$extra_posted];
            }
        }

        // Any fields left will be custom fields, so add those in to the results, but
        // stuff them into a 'custom' element.

        $fetch_transaction = array_merge(
            $fetch_transaction,
            array('custom' => array_diff_key($posted_transaction, $fetch_transaction))
        );

        return $fetch_transaction;
    }

    public function sendData($data)
    {
        // $data here will be the transaction details, in array form.
        return $this->createResponse($data);
    }

    /**
     * Allows responses from the abstract request to be overridden.
     */
    protected function createResponse($data)
    {
        return $this->response = new HostedPagesCompleteResponse($this, $data);
    }
}
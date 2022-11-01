<?php namespace Omnipay\Beanstream\Message;

abstract class AbstractProfileRequest extends AbstractRequest
{
    protected $endpoint = 'https://www.beanstream.com/api/v1/profiles';

    public function getProfileId()
    {
        return $this->getParameter('profile_id');
    }

    public function setProfileId($value)
    {
        return $this->setParameter('profile_id', $value);
    }

    public function getCardId()
    {
        return $this->getParameter('card_id');
    }

    public function setCardId($value)
    {
        return $this->setParameter('card_id', $value);
    }

    public function getComment()
    {
        return $this->getParameter('comment');
    }

    public function setComment($value)
    {
        return $this->setParameter('comment', $value);
    }

    public function sendData($data)
    {
        $header = base64_encode($this->getMerchantId() . ':' . $this->getApiPasscode());
        // Don't throw exceptions for 4xx errors
        $this->httpClient->getEventDispatcher()->addListener(
            'request.error',
            function ($event) {
                if ($event['response']->isClientError()) {
                    $event->stopPropagation();
                }
            }
        );

        if (!empty($data)) {
            $httpRequest = $this->httpClient->createRequest(
                $this->getHttpMethod(),
                $this->getEndpoint(),
                null,
                json_encode($data)
            );
        } else {
            $httpRequest = $this->httpClient->createRequest(
                $this->getHttpMethod(),
                $this->getEndpoint()
            );
        }

        $httpResponse = $httpRequest
            ->setHeader(
                'Content-Type',
                'application/json'
            )
            ->setHeader(
                'Authorization',
                'Passcode ' . $header
            )
            ->send();

        return $this->response = new ProfileResponse($this, $httpResponse->json());
    }
}

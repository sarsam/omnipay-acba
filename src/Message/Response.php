<?php

namespace Omnipay\Acba\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Acba Response.
 *
 * This is the response class for all Acba requests.
 *
 * @see \Omnipay\Acba\Gateway
 */
class Response extends AbstractResponse
{
    /**
     * Request id
     *
     * @var string URL
     */
    protected $requestId = null;

    /**
     * @var array
     */
    protected $headers = [];

    public function __construct(RequestInterface $request, $data, $headers = [])
    {
        $this->request = $request;
        $this->data = json_decode($data, true);
        $this->headers = $headers;
    }

    /**
     * Is the transaction successful?
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getCode() == 0;
    }

    public function isRedirect()
    {
        return isset($this->data['formUrl']) ? true : false;
    }

    public function getRedirectUrl()
    {
        return $this->data['formUrl'];
    }

    /**
     * Get the transaction reference.
     *
     * @return string|null
     */
    public function getTransactionReference()
    {
        return $this->data['orderNumber'];
    }

    /**
     * Get the error message from the response.
     *
     * Returns null if the request was successful.
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->data['errorMessage']  ;
    }

    public function getCode()
    {
        return $this->data['errorCode'];
    }

    /**
     * @return string|null
     */
    public function getRequestId()
    {
        if (isset($this->headers['Request-Id'])) {
            return $this->headers['Request-Id'][0];
        }

        return null;
    }
}

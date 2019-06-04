<?php

namespace Omnipay\Acba\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Acba Response.
 *
 * This is the response class for all Acba requests.
 *
 * @see \Omnipay\Acba\Gateway
 */
class Response extends AbstractResponse implements RedirectResponseInterface
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

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return isset($this->data['formUrl']) ? true : false;
    }

    /**
     * Get response redirect url
     *
     * @return string
     */
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
        if (isset($this->data['orderId'])) {
            return $this->data['orderId'];
        }

        if (isset($this->orderId)) {
            return $this->orderId;
        }

        return null;
    }

    /**
     * Get the orderNumber reference
     *
     * @return mixed
     */
    public function getOrderNumberReference()
    {
        if (isset($this->data['OrderNumber'])) {
            return $this->data['OrderNumber'];
        }

        return null;
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
        if (!$this->isSuccessful() && isset($this->data['errorMessage'])) {
            return $this->data['errorMessage'];
        }

        return null;
    }

    /**
     * Get the error code from the response.
     *
     * Returns null if the request was successful.
     *
     * @return string|null
     */
    public function getCode()
    {
        if (isset($this->data['errorCode'])) {
            return $this->data['errorCode'];
        }

        if (isset($this->data['ErrorCode'])) {
            return $this->data['ErrorCode'];
        }

        return null;
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

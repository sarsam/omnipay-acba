<?php

namespace Omnipay\Acba\Message;

use \Omnipay\Common\Message\AbstractRequest AS CommonAbstractRequest;

/**
 * Class AbstractRequest
 * @package Omnipay\Acba\Message
 */
abstract class AbstractRequest extends CommonAbstractRequest
{
    /**
     * Live or Test Endpoint URL.
     *
     * @var string URL
     */
    protected $endpoint = 'https://test.paymentgate.ru/ipaytest/rest/';
    protected $testEndpoint = 'https://test.paymentgate.ru/ipaytest/rest/';

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->getParameter('username');
    }

    /**
     * Set account login.
     *
     * @param $value
     * @return $this
     */
    public function setUserName($value)
    {
        return $this->setParameter('username', $value);
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * Set account password.
     *
     * @param $value
     * @return $this
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    abstract public function getEndpoint();

    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        $headers = [];

        return $headers;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    /**
     * Set the request language.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    /**
     * @return mixed
     */
    public function getJsonParams()
    {
        return $this->getParameter('jsonParams');
    }

    /**
     * Set the request jsonParams.
     * Fields of additional information
     *
     * @param string $value
     *
     * @return $this
     */
    public function setJsonParams($value)
    {
        return $this->setParameter('jsonParams', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function sendData($data)
    {
//        $headers = array('Authorization' => 'Basic ' . base64_encode($this->getApiKey() . ':'));
        $body = $data ? http_build_query($data, '', '&') : null;
        $httpResponse = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(), [], $body);

        return $this->createResponse($httpResponse->getBody()->getContents(), $httpResponse->getHeaders());
    }

    /**
     * @param $data
     * @param array $headers
     * @return Response
     */
    protected function createResponse($data, $headers = [])
    {
        return $this->response = new Response($this, $data, $headers);
    }

    public function getData()
    {
        $this->validate('userName', 'password');

        return [
            'userName' => $this->getUserName(),
            'password' => $this->getPassword(),
        ];
    }
}

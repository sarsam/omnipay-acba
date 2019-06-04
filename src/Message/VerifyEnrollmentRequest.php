<?php

namespace Omnipay\Acba\Message;

use Omnipay\Acba\Message\AbstractRequest;

/**
 * Class VerifyEnrollmentRequest
 * @package Omnipay\Acba\Message
 */
class VerifyEnrollmentRequest extends AbstractRequest
{
    /**
     * @return mixed
     */
    public function getPan()
    {
        return $this->getParameter('pan');
    }

    /**
     * Set the request pan.
     *
     * @param $value
     * @return $this
     */
    public function setPan($value)
    {
        return $this->setParameter('pan', $value);
    }

    /**
     * Prepare data to send
     *
     * @return array|mixed
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('pan');

        $data = parent::getData();

        $data['pan'] = $this->getPan();

        return $data;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getUrl() . '/verifyEnrollment.do';
    }
}
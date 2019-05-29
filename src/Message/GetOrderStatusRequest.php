<?php

namespace Omnipay\Acba\Message;

use Omnipay\Acba\Message\AbstractRequest;

/**
 * Class GetOrderStatusRequest
 * @package Omnipay\Acba\Message
 */
class GetOrderStatusRequest extends AbstractRequest
{
    /**
     * Prepare data to send
     *
     * @return array|mixed
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('transactionId');

        $data = parent::getData();

        $data['orderId'] = $this->getTransactionId();

        if ($this->getLanguage()) {
            $data['language'] = $this->getLanguage();
        }


        return $data;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint . '/getOrderStatus.do';
    }
}
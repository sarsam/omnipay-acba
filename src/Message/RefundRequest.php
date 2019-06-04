<?php

namespace Omnipay\Acba\Message;

/**
 * Class RefundRequest
 * @package Omnipay\Acba\Message
 */
class RefundRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionId', 'amount');

        $data = parent::getData();

        $data['orderId'] = $this->getTransactionId();
        $data['amount'] = $this->getAmountInteger();

        return $data;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getUrl() . '/refunds';
    }
}

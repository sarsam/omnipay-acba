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

        $data['amount'] = $this->getAmount();

        return $data;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint . '/refunds';
    }
}

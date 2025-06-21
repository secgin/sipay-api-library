<?php

namespace S\Sipay\Api\Payment;

use YG\ApiLibraryBase\Abstracts\Request\AbstractRequest;

class CheckPaymentStatus extends AbstractRequest
{
    public static function create(string $invoiceId)
    {
        return new self([
            'merchant_key' => '',
            'invoice_id' => $invoiceId,
            'include_pending_status' => true,
            'hash_key' => ''
        ]);
    }
}
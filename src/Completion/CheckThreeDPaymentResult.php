<?php

namespace S\Sipay\Completion;

/**
 * @property-read string $sipayStatus
 * @property-read string $orderNo
 * @property-read string $orderId
 * @property-read string $invoiceId
 * @property-read string $statusCode
 * @property-read string $statusDescription
 * @property-read string $sipayPaymentMethod
 * @property-read string $creditCardNo
 * @property-read string $transactionType
 * @property-read string $paymentStatus
 * @property-read string $paymentMethod
 * @property-read string $errorCode
 * @property-read string $error
 * @property-read string $authCode
 * @property-read float  $merchantCommission
 * @property-read float  $userCommission
 * @property-read float  $merchantCommissionPercentage
 * @property-read float $merchantCommissionFixed
 * @property-read string $installment
 * @property-read string $amount
 * @property-read string $paymentReasonCode
 * @property-read string $paymentReasonCodeDetail
 * @property-read string $hashKey
 * @property-read string $mdStatus
 * @property-read string $originalBankErrorCode
 * @property-read string $originalBankErrorDescription
 */
interface CheckThreeDPaymentResult
{

}
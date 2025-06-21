<?php

namespace S\Sipay\Completion;

/**
 * @property-read string $statusCode
 * @property-read string $statusDescription
 * @property-read string $transactionStatus
 * @property-read string $orderId
 * @property-read string $transactionId
 * @property-read string $message
 * @property-read string $reason
 * @property-read string $bankStatusCode
 * @property-read string $bankStatusDescription
 * @property-read string $invoiceId
 * @property-read string $totalRefundedAmount
 * @property-read string $productPrice
 * @property-read string $transactionAmount
 * @property-read string $refNumber
 * @property-read string $transactionType
 * @property-read string $originalBankErrorCode
 * @property-read string $originalBankErrorDescription
 * @property-read string $ccNo
 * @property-read string $paymentReasonCode
 * @property-read string $paymentReasonCodeDetail
 * @property-read string $merchantCommission
 * @property-read string $userCommission
 * @property-read string $settlementDate
 * @property-read int $installment
 * @property-read string $cardType
 * @property-read string $recurringId
 * @property-read string $recurringPlanCode // Yalnızca yinelenen işlemlerde döner",
 * @property-read string $nextActionDate // Yalnızca yinelenen işlemlerde döner ",
 * @property-read string $recurringStatus // Yalnızca yinelenen işlemlerde döner"
 */
interface CheckStatusItem
{

}
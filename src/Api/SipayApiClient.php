<?php

namespace S\Sipay\Api;

use S\Sipay\Api\Authorization\GetAccessToken;
use S\Sipay\Api\Payment\CheckPaymentStatus;
use S\Sipay\Api\Payment\CheckThreeDPayment;
use S\Sipay\Api\Payment\ConfirmPayment;
use S\Sipay\Api\Payment\PrepareThreeDPayment;
use S\Sipay\Api\Pos\GetPos;
use S\Sipay\Completion\CheckStatusResult;
use S\Sipay\Completion\CheckThreeDPaymentResult;
use S\Sipay\Completion\ConfirmPaymentResult;
use S\Sipay\Completion\GetAccessTokenResult;
use S\Sipay\Completion\GetPosResult;
use S\Sipay\Completion\PrepareThreeDPaymentResult;
use YG\ApiLibraryBase\Abstracts\Result\Result;

/**
 * @method Result|GetAccessTokenResult getAccessToken(GetAccessToken $request)
 * @method Result|PrepareThreeDPaymentResult prepareThreeDPayment(PrepareThreeDPayment $request)
 * @method Result|CheckThreeDPaymentResult checkThreeDPayment(CheckThreeDPayment $request)
 * @method Result|ConfirmPaymentResult confirmPayment(ConfirmPayment $request)
 * @method Result|CheckStatusResult checkPaymentStatus(CheckPaymentStatus $request)
 * @method Result|GetPosResult getPos(GetPos $request)
 */
interface SipayApiClient
{
}
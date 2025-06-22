<?php

namespace S\Sipay\Api;

use S\Sipay\Api\Authorization\GetAccessToken;
use S\Sipay\Api\Authorization\GetAccessTokenHandler;
use S\Sipay\Api\Payment\Handlers\CheckPaymentStatusHandler;
use S\Sipay\Api\Payment\Handlers\CheckThreeDPaymentHandler;
use S\Sipay\Api\Payment\Handlers\ConfirmPaymentHandler;
use S\Sipay\Api\Payment\Handlers\PrepareThreeDPaymentHandler;
use S\Sipay\Api\Pos\GetPosHandler;
use S\Sipay\Completion\GetAccessTokenResult;
use YG\ApiLibraryBase\Abstracts\AbstractApiClient;
use YG\ApiLibraryBase\Abstracts\Result\Result;
use YG\ApiLibraryBase\Services\SimpleAccessToken;

class ApiClient extends AbstractApiClient implements SipayApiClient
{
    protected function getRequestHandlerClasses(): array
    {
        return [
            'getAccessToken' => GetAccessTokenHandler::class,
            'prepareThreeDPayment' => PrepareThreeDPaymentHandler::class,
            'checkThreeDPayment' => CheckThreeDPaymentHandler::class,
            'confirmPayment' => ConfirmPaymentHandler::class,
            'checkPaymentStatus' => CheckPaymentStatusHandler::class,
            'getPos' => GetPosHandler::class
        ];
    }

    protected function handle(string $requestName, $request): Result
    {
        if (
            $requestName != 'getAccessToken' and
            (
                !$this->tokenStorage->has('token') or
                $this->tokenStorage->get('token')->isExpirationPassed('Europe/Istanbul')
            )
        )
        {
            $this->refreshToken();
        }

        return parent::handle($requestName, $request);
    }

    private function refreshToken(): void
    {
        $handler = $this->getRequestHandler('getAccessToken');

        /** @var Result|GetAccessTokenResult $result */
        $result = $handler->handle(GetAccessToken::create());
        if ($result->isSuccess())
        {
            $accessToken = new SimpleAccessToken(
                $result->data->token,
                date_create($result->data->expiresAt));

            $this->tokenStorage->set('token', $accessToken);
        }
    }
}
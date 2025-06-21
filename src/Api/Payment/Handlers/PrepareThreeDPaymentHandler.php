<?php

namespace S\Sipay\Api\Payment\Handlers;

use S\Sipay\Core\Result;
use YG\ApiLibraryBase\Abstracts\Request\AbstractRequestHandler;
use YG\ApiLibraryBase\Abstracts\Request\Request;
use YG\ApiLibraryBase\Abstracts\Result\Result as ResultInterface;

class PrepareThreeDPaymentHandler extends AbstractRequestHandler
{
    public function handle(Request $request): ResultInterface
    {
        $accessToken = $this->tokenStorageService->get('token');

        $params = $request->getParams();
        $formData = array_merge([
            'authorization' => 'Bearer ' . $accessToken->getToken(),
            'merchant_key' => $this->config->get('merchantKey'),
            'hash_key' => $this->prepareHashKey($params)
        ], $params);

        return Result::success($formData);
    }

    private function prepareHashKey(array $params): string
    {
        $total = $params['total'];
        $installmentsNumber = $params['installments_number'];
        $currencyCode = $params['currency_code'];
        $invoiceId = $params['invoice_id'];
        $merchantKey = $this->config->get('merchantKey');
        $appSecret = $this->config->get('appSecret');

        return $this->generateHashKey($total, $installmentsNumber, $currencyCode, $merchantKey, $invoiceId, $appSecret);
    }

    private function generateHashKey(float  $total, int $installment, string $currencyCode, string $merchantKey,
                                     string $invoiceId, string $appSecret)
    {
        $data = $total . '|' . $installment . '|' . $currencyCode . '|' . $merchantKey . '|' . $invoiceId;

        $iv = substr(sha1(mt_rand()), 0, 16);
        $password = sha1($appSecret);

        $salt = substr(sha1(mt_rand()), 0, 4);
        $saltWithPassword = hash('sha256', $password . $salt);

        $encrypted = openssl_encrypt("$data", 'aes-256-cbc', "$saltWithPassword", null, $iv);

        $msg_encrypted_bundle = "$iv:$salt:$encrypted";
        return str_replace('/', '__', $msg_encrypted_bundle);
    }
}
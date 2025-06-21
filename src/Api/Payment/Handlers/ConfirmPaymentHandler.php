<?php

namespace S\Sipay\Api\Payment\Handlers;

use S\Sipay\Core\Result;
use YG\ApiLibraryBase\Abstracts\Request\AbstractRequestHandler;
use YG\ApiLibraryBase\Abstracts\Request\Request;
use YG\ApiLibraryBase\Abstracts\Result\Result as ResultInterface;
use YG\ApiLibraryBase\Http\HttpRequest;

class ConfirmPaymentHandler extends AbstractRequestHandler
{
    public function handle(Request $request): ResultInterface
    {
        $params = $request->getParams();

        $merchantKey = $this->config->get('merchantKey');
        $appSecret = $this->config->get('appSecret');
        $invoiceId = $params['invoice_id'] ?? '';
        $status = $params['status'] ?? '';
        $total = $params['total'];

        $hashKey = $this->generateConfirmPaymentHashKey($merchantKey, $invoiceId, $status, $appSecret);

        $httpRequest = HttpRequest::post($this->config->get('serviceUrl') . '/api/confirmPayment')
            ->setBearerAuthentication($this->tokenStorageService->get('token')->getToken())
            ->setData([
                'invoice_id' => $invoiceId,
                'merchant_key' => $merchantKey,
                'status' => $status,
                'hash_key' => $hashKey,
                'total' => $total
            ]);

        $httpResult = $this->httpClient->send($httpRequest);

        return Result::create($httpResult);
    }

    private function generateConfirmPaymentHashKey($merchant_key, $invoice_id, $status, $app_secret)
    {

        $data = $merchant_key . '|' . $invoice_id . '|' . $status;

        $iv = substr(sha1(mt_rand()), 0, 16);
        $password = sha1($app_secret);

        $salt = substr(sha1(mt_rand()), 0, 4);
        $saltWithPassword = hash('sha256', $password . $salt);

        $encrypted = openssl_encrypt(
            "$data", 'aes-256-cbc', "$saltWithPassword", null, $iv
        );
        $msg_encrypted_bundle = "$iv:$salt:$encrypted";
        $msg_encrypted_bundle = str_replace('/', '__', $msg_encrypted_bundle);
        return $msg_encrypted_bundle;
    }
}
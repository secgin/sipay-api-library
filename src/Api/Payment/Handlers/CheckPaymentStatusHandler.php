<?php

namespace S\Sipay\Api\Payment\Handlers;

use S\Sipay\Core\Result;
use YG\ApiLibraryBase\Abstracts\Request\AbstractRequestHandler;
use YG\ApiLibraryBase\Abstracts\Request\Request;
use YG\ApiLibraryBase\Abstracts\Result\Result as ResultInterface;
use YG\ApiLibraryBase\Http\HttpRequest;

class CheckPaymentStatusHandler extends AbstractRequestHandler
{

    public function handle(Request $request): ResultInterface
    {
        $params = $request->getParams();

        $invoiceId = $params['invoice_id'] ?? '';
        $merchantKey = $this->config->get('merchantKey');
        $appSecret = $this->config->get('appSecret');


        $params = array_merge($params, [
            'merchant_key' => $merchantKey,
            'hash_key' => $this->generateRefundHashKey($invoiceId, $merchantKey, $appSecret)
        ]);

        $httpRequest = HttpRequest::post($this->config->get('serviceUrl') . '/api/checkstatus')
            ->setBearerAuthentication($this->tokenStorageService->get('token')->getToken())
            ->setData($params);

        $httpResult = $this->httpClient->send($httpRequest);

        return Result::create($httpResult);
    }

    private function generateRefundHashKey($invoice_id, $merchant_key, $app_secret)
    {
        $data = $invoice_id . '|' . $merchant_key;
        $iv = substr(sha1(mt_rand()), 0, 16);
        $password = sha1($app_secret);
        $salt = substr(sha1(mt_rand()), 0, 4);
        $saltWithPassword = hash('sha256', $password . $salt);
        $encrypted = openssl_encrypt(
            "$data", 'aes-256-cbc', "$saltWithPassword", null, $iv
        );
        $msg_encrypted_bundle = "$iv:$salt:$encrypted";
        $hash_key = str_replace('/', '__', $msg_encrypted_bundle);
        return $hash_key;
    }
}
<?php

namespace S\Sipay\Api\Pos;

use S\Sipay\Core\Result;
use YG\ApiLibraryBase\Abstracts\Request\AbstractRequestHandler;
use YG\ApiLibraryBase\Abstracts\Request\Request;
use YG\ApiLibraryBase\Abstracts\Result\Result as ResultInterface;
use YG\ApiLibraryBase\Http\HttpRequest;

class GetPosHandler extends AbstractRequestHandler
{
    public function handle(Request $request): ResultInterface
    {
        $params = $request->getParams();
        $params['merchant_key'] = $this->config->get('merchantKey');

        $httpRequest = HttpRequest::get($this->config->get('serviceUrl') . '/api/getpos')
            ->setBearerAuthentication($this->tokenStorageService->get('token')->getToken())
            ->setData($params);

        $httpResult = $this->httpClient->send($httpRequest);

        return Result::create($httpResult);
    }
}
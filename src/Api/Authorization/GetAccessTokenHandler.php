<?php

namespace S\Sipay\Api\Authorization;

use S\Sipay\Core\Result;
use YG\ApiLibraryBase\Abstracts\Request\AbstractRequestHandler;
use YG\ApiLibraryBase\Abstracts\Request\Request;
use YG\ApiLibraryBase\Abstracts\Result\Result as ResultInterface;
use YG\ApiLibraryBase\Http\HttpRequest;

class GetAccessTokenHandler extends AbstractRequestHandler
{
    public function handle(Request $request): ResultInterface
    {
        $httpRequest = HttpRequest::post($this->config->get('serviceUrl') . '/api/token')
            ->setData([
                'app_id' => $this->config->get('appKey'),
                'app_secret' => $this->config->get('appSecret')
            ]);

        $httpResult = $this->httpClient->send($httpRequest);

        return Result::create($httpResult);
    }
}
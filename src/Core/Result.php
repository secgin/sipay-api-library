<?php

namespace S\Sipay\Core;

use YG\ApiLibraryBase\Abstracts\Http\HttpResult;
use YG\ApiLibraryBase\Abstracts\Result\AbstractResult;

class Result extends AbstractResult
{
    private bool $success;
    private string $errorCode;
    private string $errorMessage;

    public static function create(HttpResult $httpResult): Result
    {
        $result = new self();
        $result->success = $httpResult->isSuccess();
        $result->errorCode = $httpResult->getErrorCode() ?? '';
        $result->errorMessage = $httpResult->getErrorMessage() ?? '';

        $data = json_decode($httpResult->getContent()) ?? null;
        $result->data = $data;

        if (isset($data->status_code))
        {
            $statusCode = $data->status_code;
            $statusDescription = $data->status_description;

            if ($statusCode == 100)
            {
                $result->success = true;
                $result->errorCode = $statusCode;
                $result->errorMessage = $statusDescription;
            }
            else
            {
                $result->success = false;
                $result->errorCode = $statusCode;
                $result->errorMessage = $statusDescription;
            }
        }

        return $result;
    }

    public static function success($data): Result
    {
        $result = new self();
        $result->success = true;
        $result->data = $data;
        return $result;
    }

    public static function fail(string $errorCode, string $errorMessage, $data = null): Result
    {
        $result = new self();
        $result->success = false;
        $result->errorCode = $errorCode;
        $result->errorMessage = $errorMessage;
        $result->data = $data;
        return $result;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function getData()
    {
       return $this->data;
    }

    private function camelToSnakeCase($camelCase): string
    {
        $result = '';

        for ($i = 0; $i < strlen($camelCase); $i++)
        {
            $char = $camelCase[$i];

            if (ctype_upper($char))
                $result .= '_' . strtolower($char);
            else
                $result .= $char;
        }

        return ltrim($result, '-');
    }

    public function __get($name)
    {
        if ($name == 'data')
        {
            if (isset($this->data->data))
            {
                if (is_array($this->data->data) or is_object($this->data->data))
                    return new WrapperModel($this->data->data);

                return $this->data->data;
            }

            return new WrapperModel($this->data->data ?? $this->data);
        }

        $propertyName = $name;
        if (isset($this->data->$propertyName))
            return $this->data->$propertyName;

        $propertyName = $this->camelToSnakeCase($name);
        if (isset($this->data->$propertyName))
            return $this->data->$propertyName;

        return parent::__get($name);
    }
}
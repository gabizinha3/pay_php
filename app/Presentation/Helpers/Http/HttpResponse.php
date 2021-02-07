<?php

namespace App\Presentation\Helpers\Http;

use App\Presentation\Errors\MissingParamError;

class HttpResponse
{
    public function badRequest($paramName)
    {
        $error = new MissingParamError($paramName);
        return [
            'statusCode' => 400,
            'body' => $error->message
        ];
    }

    public function serverError()
    {
        return [
            'statusCode' => 500
        ];
    }

    public function ok($data)
    {
        return [
            'statusCode' => 200,
            'body' => $data
        ];
    }

    public function customizeError($statusCode, $body)
    {
        return [
            'statusCode' => $statusCode,
            'body' => $body
        ];
    }
}

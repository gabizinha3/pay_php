<?php

namespace App\Presentation\Helpers\Http;

use App\Presentation\Errors\MissingParamError;
use App\Presentation\Errors\InvalidParamError;
use App\Presentation\Errors\NotFoundError;

class HttpResponse
{
    public function badRequest($paramName)
    {
        $error = new MissingParamError($paramName);
        return (object) [
            'statusCode' => 400,
            'body' => $error->message
        ];
    }

    public function invalidRequest($paramName)
    {
        $error = new InvalidParamError($paramName);
        return (object) [
            'statusCode' => 400,
            'body' => $error->message
        ];
    }

    public function notFound($paramName)
    {
        $error = new NotFoundError($paramName);
        return (object) [
            'statusCode' => 404,
            'body' => $error->message
        ];
    }

    public function serverError()
    {
        return (object) [
            'statusCode' => 500,
            'body' => 'Internal error'
        ];
    }

    public function ok($data)
    {
        return (object) [
            'statusCode' => 200,
            'body' => $data
        ];
    }

    public function customizeError($statusCode, $body)
    {
        return (object) [
            'statusCode' => $statusCode,
            'body' => $body
        ];
    }
}

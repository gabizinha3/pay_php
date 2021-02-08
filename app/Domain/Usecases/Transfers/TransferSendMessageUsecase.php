<?php

namespace App\Domain\Usecases\Transfers;

use App\Presentation\Helpers\Http\HttpResponse;

class TransferSendMessageUsecase
{
    private $requestHttpClient;
    public function __construct($requestHttpClient)
    {
        $this->requestHttpClient = $requestHttpClient;
    }

    public function send()
    {
        $reqAuth = $this->requestHttpClient->get([
            'url' => (env('API_URL') . 'b19f7b9f-9cbf-4fc6-ad22-dc30601aec04'),
            'body' => null
        ]);
        
        if($reqAuth && $reqAuth['message'] !== 'Enviado')
        {
            $httpResponse = new HttpResponse();
            return $httpResponse->customizeError(400, 'Message not sent');
        }
    }
}

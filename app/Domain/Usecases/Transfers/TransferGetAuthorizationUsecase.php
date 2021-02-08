<?php

namespace App\Domain\Usecases\Transfers;

use App\Presentation\Helpers\Http\HttpResponse;

class TransferGetAuthorizationUsecase
{
    private $requestHttpClient;
    public function __construct($requestHttpClient)
    {
        $this->requestHttpClient = $requestHttpClient;
    }

    public function get()
    {
        $reqAuth = $this->requestHttpClient->get([
            'url' => (env('API_URL') . '8fafdd68-a090-496f-8c9a-3442cf30dae6'),
            'body' => null
        ]);

        if($reqAuth && $reqAuth['message'] !== 'Autorizado')
        {
            $httpResponse = new HttpResponse();
            return $httpResponse->customizeError(401, 'Transfer unauthorized');
        }
    }
}

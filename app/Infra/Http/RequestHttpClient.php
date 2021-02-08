<?php

namespace App\Infra\Http;

use Illuminate\Support\Facades\Http;

class RequestHttpClient
{
    public function get($params)
    {
        try
        {
            return Http::get($params['url'], $params['body']);
        }
        catch(Exception $err)
        {
            return $err;
        }
    }
}

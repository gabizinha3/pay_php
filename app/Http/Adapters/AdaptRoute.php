<?php

namespace App\Http\Adapters;

use Illuminate\Http\Request;

class AdaptRoute
{
  private $controller;
  public function __construct($controller)
  {
    $this->controller = $controller;
  }

  public function handle(Request $httpRequest)
  {
    $req = [
      'body' => $httpRequest->all()
    ];
    $httpResponse = $this->controller->handle($req);
    return response()->json([
      'body' => $httpResponse->body,
      'statusCode' => $httpResponse->statusCode
    ], $httpResponse->statusCode);
  }
}

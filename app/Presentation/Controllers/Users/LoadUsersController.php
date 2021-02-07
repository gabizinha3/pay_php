<?php

namespace App\Presentation\Controllers\Users;

use Exception;
use Illuminate\Http\Request;
use App\Presentation\Protocols\Controller;
use App\Presentation\Helpers\Http\HttpResponse;

class LoadUsersController extends Controller
{
  private $loadUsersUsecase;
  public function __construct($loadUsersUsecase)
  {
    parent::__construct();
    $this->loadUsersUsecase = $loadUsersUsecase;
  }

  public function handle($httpRequest) {
    try
    {
      $httpResponse = new HttpResponse();
      return $httpResponse->ok($this->loadUsersUsecase->load($httpRequest->query()));
    }
    catch (Exception $err)
    {
      $httpResponse = new HttpResponse();
      return $httpResponse->serverError();
    }
  }
}

<?php

namespace App\Presentation\Controllers\Users;

use Exception;
use Illuminate\Http\Request;
use App\Presentation\Protocols\Controller;
use App\Presentation\Helpers\Http\HttpResponse;

class CreateUserController extends Controller
{
  private $addUserUsecase;
  private $validation;
  public function __construct($addUserUsecase, $validation)
  {
    parent::__construct();
    $this->addUserUsecase = $addUserUsecase;
    $this->validation = $validation;
  }

  public function handle($httpRequest) {
    try
    {
      $httpResponse = new HttpResponse();

      $errorValidation = $this->validation->validate($httpRequest->body);
      if ($errorValidation)
      {
        return $errorValidation;
      }
      
      $production = $this->addUserUsecase->add(
        $httpRequest->body['name'],
        $httpRequest->body['document'],
        $httpRequest->body['email'],
        $httpRequest->body['password'],
        $httpRequest->body['user_type_id']
      );
      return $httpResponse->ok($production);
    }
    catch (Exception $err)
    {
      $httpResponse = new HttpResponse();
      return $httpResponse->serverError();
    }
  }
}

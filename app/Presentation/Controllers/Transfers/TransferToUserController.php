<?php

namespace App\Presentation\Controllers\Transfers;

use Exception;
use Illuminate\Http\Request;
use App\Presentation\Protocols\Controller;
use App\Presentation\Helpers\Http\HttpResponse;

class TransferToUserController extends Controller
{
  private $transferToUserUsecase;
  private $validation;
  public function __construct($transferToUserUsecase, $validation)
  {
    parent::__construct();
    $this->transferToUserUsecase = $transferToUserUsecase;
    $this->validation = $validation;
  }

  public function handle($httpRequest) {
    try
    {
      $httpResponse = new HttpResponse();

      $payer = $httpRequest->body['payer'][0];
      if($payer['userType']->permission_ted !== true)
      {
        return $httpResponse->customizeError(401, 'User unauthorized to transfer');
      }

      $errorValidation = $this->validation->validate($httpRequest->body);
      if ($errorValidation)
      {
        return $errorValidation;
      }
      
      $production = $this->transferToUserUsecase->transfer(
        $httpRequest->body['payer_id'],
        $httpRequest->body['payee_id'],
        $httpRequest->body['amount']
      );
      if($production && !empty($production->statusCode))
      {
        return $httpResponse->customizeError($production->statusCode, $production->body);
      }
      return $httpResponse->ok($production);
    }
    catch (Exception $err)
    {
      $httpResponse = new HttpResponse();
      return $httpResponse->serverError();
    }
  }
}

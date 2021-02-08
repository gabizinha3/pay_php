<?php

namespace App\Domain\Usecases\Transfers;

class AddTransferUsecase
{
  private $transfersRepository;
  public function __construct($transfersRepository)
  {
    $this->transfersRepository = $transfersRepository;
  }

  public function add($payer_id, $payee_id, $amount, $status)
  {
    $newTransfer = new $this->transfersRepository;
    
    $newTransfer->payer_id = $payer_id;
    $newTransfer->payee_id = $payee_id;
    $newTransfer->amount = $amount;
    $newTransfer->status = $status;
    
    $newTransfer->save();

    return $newTransfer;
  }
}

<?php

namespace App\Domain\Usecases\Balances;

class AddBalanceUsecase
{
  private $balancesRepository;
  public function __construct($balancesRepository)
  {
    $this->balancesRepository = $balancesRepository;
  }

  public function add($user_id, $amount)
  {
    $newBalance = new $this->balancesRepository;
    
    $newBalance->user_id = $user_id;
    $newBalance->amount = $amount;
    
    $newBalance->save();

    return $newBalance;
  }
}

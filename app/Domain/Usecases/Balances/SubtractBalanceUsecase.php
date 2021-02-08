<?php

namespace App\Domain\Usecases\Balances;

class SubtractBalanceUsecase
{
  private $balancesRepository;
  public function __construct($balancesRepository)
  {
    $this->balancesRepository = $balancesRepository;
  }

  public function subtract($user_id, $amount)
  {
    $balance = $this->balancesRepository::where('user_id', $user_id)->first();
    $balance->amount = (floatval($balance->amount) - floatval($amount));
    
    $balance->save();

    return $balance;
  }
}

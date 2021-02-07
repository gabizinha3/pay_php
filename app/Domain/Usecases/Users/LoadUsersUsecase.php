<?php

namespace App\Domain\Usecases\Users;

class LoadUsersUsecase
{
  private $usersRepository;
  public function __construct($usersRepository)
  {
    $this->usersRepository = $usersRepository;
  }

  public function load($query)
  {
    $users = $this->usersRepository::where($query)->get();
    return $users;
  }
}

<?php

namespace App\Domain\Usecases\Users;

class AddUserUsecase
{
  private $usersRepository;
  private $addBalanceUsecase;
  public function __construct($usersRepository, $addBalanceUsecase)
  {
    $this->usersRepository = $usersRepository;
    $this->addBalanceUsecase = $addBalanceUsecase;
  }

  public function add($name, $document, $email, $password, $user_type_id)
  {
    $newUser = new $this->usersRepository;

    $newUser->name = $name;
    $newUser->document = $document;
    $newUser->email = $email;
    $newUser->password = $password;
    $newUser->user_type_id = $user_type_id;
    
    $newUser->save();

    $balance = $this->addBalanceUsecase->add($newUser->id, 0);

    return $newUser;
  }
}

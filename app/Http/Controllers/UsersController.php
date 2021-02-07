<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Presentation\Controllers\Users\LoadUsersController;
use App\Presentation\Controllers\Users\CreateUserController;
use App\Models\Users;
use App\Models\Balances;
use App\Domain\Usecases\Users\LoadUsersUsecase;
use App\Domain\Usecases\Users\AddUserUsecase;
use App\Http\Adapters\AdaptRoute;
use App\Validations\RequiredFieldValidation;
use App\Validations\ValidationComposite;
use App\Domain\Usecases\Balances\AddBalanceUsecase;

class UsersController extends Controller
{
    private $request;
    private $model;
    private $modelBalances;

    public function __construct(Request $request, Users $users, Balances $balances)
    {
        $this->request = $request;
        $this->model = $users;
        $this->modelBalances = $balances;
    }

    private function makeRepository()
    {
        return $this->model;
    }

    private function makeBalanceRepository()
    {
        return $this->modelBalances;
    }

    private function makeAddBalanceUsecase() {
        $addBalance = new AddBalanceUsecase($this->makeBalanceRepository());
        return $addBalance;
    }

    private function makeValidation()
    {
        $validations = [];
        $fields = [
            'name',
            'document',
            'email',
            'password',
            'user_type_id'
        ];
        foreach ($fields as $field)
        {
            array_push($validations, new RequiredFieldValidation($field));
        }
        return new ValidationComposite($validations);
    }

    private function makeUseCase()
    {
        $addUser = new AddUserUsecase($this->makeRepository(), $this->makeAddBalanceUsecase());
        $loadUser = new LoadUsersUsecase($this->makeRepository());
        return (object) [
            'addUser' => $addUser,
            'loadUser' => $loadUser
        ];
    }

    public function makeCreateUserController()
    {
        $usecases = $this->makeUseCase();
        $validation = $this->makeValidation();
        $controller = new CreateUserController($usecases->addUser, $validation);
        $adapter = new AdaptRoute($controller);
        return $adapter->handle($this->request);
    }

    public function makeLoadUsersController()
    {
        $usecases = $this->makeUseCase();
        $controller = new LoadUsersController($usecases->loadUser);
        $adapter = new AdaptRoute($controller);
        return $adapter->handle($this->request);
    }
}
  
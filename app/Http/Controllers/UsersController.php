<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Presentation\Controllers\Users\LoadUsersController;
use App\Models\Users;
use App\Domain\Usecases\Users\LoadUsersUsecase;
use App\Http\Adapters\AdaptRoute;

class UsersController extends Controller
{
    private $request;
    private $users;

    public function __construct(Request $request, Users $users)
    {
        $this->request = $request;
        $this->model = $users;
    }

    private function makeRepository()
    {
        return $this->model;
    }

    private function makeUseCase()
    {
        $loadUser = new LoadUsersUsecase($this->makeRepository());
        return (object) [
            'loadUser' => $loadUser
        ];
    }

    public function makeLoadUsersController()
    {
        $usecases = $this->makeUseCase();
        $controller = new LoadUsersController($usecases->loadUser);
        $adapter = new AdaptRoute($controller);
        return $adapter->handle($this->request);
    }
}

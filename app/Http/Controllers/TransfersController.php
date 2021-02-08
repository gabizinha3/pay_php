<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Presentation\Controllers\Transfers\TransferToUserController;
use App\Models\Users;
use App\Models\Transfers;
use App\Models\Balances;
use App\Domain\Usecases\Transfers\TransferToUserUsecase;
use App\Domain\Usecases\Transfers\AddTransferUsecase;
use App\Domain\Usecases\Users\LoadUsersUsecase;
use App\Domain\Usecases\Users\AddUserUsecase;
use App\Domain\Usecases\Balances\SubtractBalanceUsecase;
use App\Domain\Usecases\Balances\SumBalanceUsecase;
use App\Http\Adapters\AdaptRoute;
use App\Validations\RequiredFieldValidation;
use App\Validations\EntryExistsValidation;
use App\Validations\GreaterThanValidation;
use App\Validations\ValidationComposite;

class TransfersController extends Controller
{
    private $request;
    private $model;
    private $modelUsers;
    private $modelBalances;

    public function __construct(Request $request, Transfers $transfers, Users $users, Balances $balances)
    {
        $this->request = $request;
        $this->model = $transfers;
        $this->modelUsers = $users;
        $this->modelBalances = $balances;
    }

    private function makeRepository()
    {
        return $this->model;
    }

    private function makeUsersRepository()
    {
        return $this->modelUsers;
    }

    private function makeBalancesRepository()
    {
        return $this->modelBalances;
    }

    private function makeLoadUsersUsecase() {
        $loadUsers = new LoadUsersUsecase($this->makeUsersRepository());
        return $loadUsers;
    }

    private function makeSumBalanceUsecase() {
        $sum = new SumBalanceUsecase($this->makeBalancesRepository());
        return $sum;
    }

    private function makeSubtractBalanceUsecase() {
        $subtract = new SubtractBalanceUsecase($this->makeBalancesRepository());
        return $subtract;
    }

    private function makeAddTransferUsecase() {
        $transfer = new AddTransferUsecase($this->makeRepository());
        return $transfer;
    }

    private function makeValidation()
    {
        $validations = [];
        $fields = [
            'payer_id',
            'payee_id',
            'amount'
        ];
        foreach ($fields as $field)
        {
            array_push($validations, new RequiredFieldValidation($field));
        }

        $fieldsEntry = [
            'payer',
            'payee'
        ];
        foreach ($fieldsEntry as $field)
        {
            array_push($validations, new EntryExistsValidation($field));
        }

        array_push($validations, new GreaterThanValidation('balanceAmount', 'minBalance'));

        return new ValidationComposite($validations);
    }

    private function makeUseCase()
    {
        $transferToUser = new TransferToUserUsecase(
            $this->makeSumBalanceUsecase(),
            $this->makeSubtractBalanceUsecase(),
            $this->makeAddTransferUsecase()
        );
        $loadUsersUsecase = $this->makeLoadUsersUsecase();
        return (object) [
            'transferToUser' => $transferToUser,
            'loadUsersUsecase' => $loadUsersUsecase
        ];
    }

    public function makeTransferToUserController()
    {
        $usecases = $this->makeUseCase();

        $validationFields = $this->request;
        $validationFields['payer'] = $usecases->loadUsersUsecase->load([ 'id' => $validationFields->payer_id ]);
        $validationFields['payee'] = $usecases->loadUsersUsecase->load([ 'id' => $validationFields->payee_id ]);

        if(count($validationFields->payer) > 0)
        {
            $validationFields['balanceAmount'] = (floatval($validationFields->payer[0]->balance->amount) - floatval($validationFields->amount));
            $validationFields['minBalance'] = 0;
        }

        $validation = $this->makeValidation();

        $controller = new TransferToUserController($usecases->transferToUser, $validation);
        $adapter = new AdaptRoute($controller);
        return $adapter->handle($validationFields);
    }
}
  
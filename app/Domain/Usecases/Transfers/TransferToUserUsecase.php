<?php

namespace App\Domain\Usecases\Transfers;

class TransferToUserUsecase
{
    private $sumBalanceUsecase;
    private $subtractBalanceUsecase;
    private $addTransferUsecase;
    public function __construct($sumBalanceUsecase, $subtractBalanceUsecase, $addTransferUsecase)
    {
        $this->sumBalanceUsecase = $sumBalanceUsecase;
        $this->subtractBalanceUsecase = $subtractBalanceUsecase;
        $this->addTransferUsecase = $addTransferUsecase;
    }

    public function transfer($payer_id, $payee_id, $amount)
    {
        // autorizacao
        $subtract = $this->subtractBalanceUsecase->subtract($payer_id, $amount);
        $sum = $this->sumBalanceUsecase->sum($payee_id, $amount);
        $transfer = $this->addTransferUsecase->add($payer_id, $payee_id, $amount, 'authorized');
        // envia mensagem
        //$status = ['sended', 'authorized', 'unauthorized', 'done', 'error']
        return [
            'transfer' => $transfer
        ];
    }
}

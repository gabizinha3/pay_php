<?php

namespace App\Domain\Usecases\Transfers;

class TransferToUserUsecase
{
    private $sumBalanceUsecase;
    private $subtractBalanceUsecase;
    private $addTransferUsecase;
    private $transferGetAuthorizationUsecase;
    private $transferSendMessageUsecase;
    public function __construct($sumBalanceUsecase, $subtractBalanceUsecase, $addTransferUsecase, $transferGetAuthorizationUsecase, $transferSendMessageUsecase)
    {
        $this->sumBalanceUsecase = $sumBalanceUsecase;
        $this->subtractBalanceUsecase = $subtractBalanceUsecase;
        $this->addTransferUsecase = $addTransferUsecase;
        $this->transferGetAuthorizationUsecase = $transferGetAuthorizationUsecase;
        $this->transferSendMessageUsecase = $transferSendMessageUsecase;
    }

    public function transfer($payer_id, $payee_id, $amount)
    {
        $reqAuth = $this->transferGetAuthorizationUsecase->get();
        if($reqAuth)
        {
            return $reqAuth;
        }
        
        $subtract = $this->subtractBalanceUsecase->subtract($payer_id, $amount);
        $sum = $this->sumBalanceUsecase->sum($payee_id, $amount);
        $transfer = $this->addTransferUsecase->add($payer_id, $payee_id, $amount, 'authorized');
        $reqMessage = $this->transferSendMessageUsecase->send();
        if($reqMessage)
        {
            $sum = $this->sumBalanceUsecase->sum($payer_id, $amount);
            $subtract = $this->subtractBalanceUsecase->subtract($payee_id, $amount);
            return $reqMessage;
        }
        return [
            'transfer' => $transfer
        ];
    }
}

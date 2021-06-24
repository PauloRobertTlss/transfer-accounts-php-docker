<?php

namespace Tests\Stubs\Services\Transaction\Bridge\Workers;

use App\Domain\Financial\Transaction\Request\TransactionRequest;
use App\Services\Transaction\Bridge\Transaction;

class BaseTransactionWorkerStub implements Transaction
{

    public function payload(TransactionRequest $request)
    {
        return true;
    }
}

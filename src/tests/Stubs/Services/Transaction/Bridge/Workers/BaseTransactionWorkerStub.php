<?php

namespace Tests\Stubs\Services\Transaction\Bridge\Workers;

use App\Domain\Financial\Transaction\Request\TransactionRequestInterface;
use App\Services\Transaction\Bridge\TransactionInterface;

class BaseTransactionWorkerStub implements TransactionInterface
{

    public function payload(TransactionRequestInterface $request)
    {
        return true;
    }
}

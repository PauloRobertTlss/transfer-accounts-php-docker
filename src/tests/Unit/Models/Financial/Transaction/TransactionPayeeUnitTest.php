<?php declare(strict_types=1);

namespace Tests\Unit\Models\Financial\Transaction;

use App\Domain\Financial\Transaction\Entity\Contract\TransactionPayee as TransactionPayeeContract;
use App\Models\Financial\Transaction\TransactionPayee;

class TransactionPayeeUnitTest extends BaseTransactionUnitTest
{
    protected function instance(): string
    {
        return TransactionPayee::class;
    }

    protected function transactionInterface(): string
    {
        return TransactionPayeeContract::class;
    }

    protected function table(): string
    {
        return TransactionPayee::TABLE;
    }

}

<?php declare(strict_types=1);

namespace Tests\Unit\Models\Financial\Transaction;

use App\Domain\Financial\Transaction\Entity\Contract\TransactionPayer as TransactionPayerContract;
use App\Models\Financial\Transaction\TransactionPayer;

class TransactionPayerUnitTest extends BaseTransactionUnitTest
{
    protected function instance(): string
    {
        return TransactionPayer::class;
    }

    protected function transactionInterface(): string
    {
        return TransactionPayerContract::class;
    }

    protected function table(): string
    {
        return TransactionPayer::TABLE;
    }

}

<?php declare(strict_types=1);

namespace Tests\Unit\Models\Financial\Transaction;

use App\Domain\Financial\Transaction\Entity\Contract\TransactionPayerInterface;
use App\Models\Financial\Transaction\TransactionPayer;
use PHPUnit\Framework\TestCase;

class TransactionPayerUnitTest extends BaseTransactionUnitTest
{
    protected function instance(): string
    {
        return TransactionPayer::class;
    }

    protected function transactionInterface(): string
    {
        return TransactionPayerInterface::class;
    }

    protected function table(): string
    {
        return TransactionPayerInterface::TABLE;
    }

}

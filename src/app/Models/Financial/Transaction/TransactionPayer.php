<?php declare(strict_types=1);

namespace App\Models\Financial\Transaction;

use App\Domain\Financial\Transaction\Entity\Contract\TransactionPayer as TransactionPayerContract;

final class TransactionPayer extends BaseTransaction implements TransactionPayerContract
{
    protected string $table = self::TABLE;

}

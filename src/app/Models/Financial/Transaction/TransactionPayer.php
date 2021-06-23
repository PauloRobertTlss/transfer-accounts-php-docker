<?php declare(strict_types=1);

namespace App\Models\Financial\Transaction;

use App\Domain\Financial\Transaction\Entity\Contract\TransactionPayerInterface;

class TransactionPayer extends AbstractTransaction implements TransactionPayerInterface
{
    protected string $table = self::TABLE;

}

<?php declare(strict_types=1);

namespace App\Models\Financial\Transaction;

use App\Domain\Financial\Transaction\Entity\Contract\TransactionPayeeInterface;

class TransactionPayee extends AbstractTransaction implements TransactionPayeeInterface
{
    protected string $table = self::TABLE;

}

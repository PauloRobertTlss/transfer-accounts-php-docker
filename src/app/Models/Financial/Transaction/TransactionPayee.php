<?php declare(strict_types=1);

namespace App\Models\Financial\Transaction;

use App\Domain\Financial\Transaction\Entity\Contract\TransactionPayee as TransactionPayeeContract;

final class TransactionPayee extends BaseTransaction implements TransactionPayeeContract
{
    protected  $table = self::TABLE;

}

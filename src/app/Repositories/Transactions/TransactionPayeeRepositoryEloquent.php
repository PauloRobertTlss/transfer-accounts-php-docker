<?php declare(strict_types=1);

namespace App\Repositories\Transactions;

use App\Common\Repositories\BaseRepository;
use App\Domain\Financial\Transaction\Repository\TransactionPayeeRepository;
use App\Models\Financial\Transaction\TransactionPayee;

final class TransactionPayeeRepositoryEloquent extends BaseRepository implements TransactionPayeeRepository
{
    public function model(): string
    {
        return TransactionPayee::class;
    }
}

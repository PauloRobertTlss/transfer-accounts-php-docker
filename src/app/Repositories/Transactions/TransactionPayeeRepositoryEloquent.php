<?php declare(strict_types=1);

namespace App\Repositories\Transactions;

use App\Common\Repositories\BaseRepository;
use App\Domain\Financial\Transaction\Repository\TransactionPayeeRepositoryInterface;
use App\Models\Financial\Transaction\TransactionPayee;

class TransactionPayeeRepositoryEloquent extends BaseRepository implements TransactionPayeeRepositoryInterface
{
    public function model(): string
    {
        return TransactionPayee::class;
    }
}

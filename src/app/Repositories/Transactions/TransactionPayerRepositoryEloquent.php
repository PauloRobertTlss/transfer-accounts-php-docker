<?php declare(strict_types=1);

namespace App\Repositories\Transactions;

use App\Common\Repositories\BaseRepository;
use App\Domain\Financial\Transaction\Repository\TransactionPayerRepositoryInterface;
use App\Models\Financial\Transaction\TransactionPayer;

class TransactionPayerRepositoryEloquent extends BaseRepository implements TransactionPayerRepositoryInterface
{
    public function model(): string
    {
        return TransactionPayer::class;
    }

}

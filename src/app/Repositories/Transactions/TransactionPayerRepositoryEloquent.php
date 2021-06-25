<?php declare(strict_types=1);

namespace App\Repositories\Transactions;

use App\Common\Repositories\BaseRepository;
use App\Domain\Financial\Transaction\Repository\TransactionPayerRepository;
use App\Models\Financial\Transaction\TransactionPayer;

final class TransactionPayerRepositoryEloquent extends BaseRepository implements TransactionPayerRepository
{
    public function model(): string
    {
        return TransactionPayer::class;
    }

}

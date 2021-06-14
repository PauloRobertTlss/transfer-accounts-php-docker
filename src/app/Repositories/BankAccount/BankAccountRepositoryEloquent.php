<?php declare(strict_types=1);

namespace App\Repositories\BankAccount;

use App\Common\Repositories\BaseRepository;
use App\Domain\Financial\BankAccount\Repository\BankAccountRepositoryInterface;
use App\Models\Financial\BankAccount\BankAccountModel;

/**
 * Class BankAccountRepositoryEloquent
 * @package App\Repositories\BankAccount
 */
class BankAccountRepositoryEloquent extends BaseRepository implements BankAccountRepositoryInterface
{
    public function model(): string
    {
        return BankAccountModel::class;
    }

    public function addBalance(int $id,float $newValue)
    {
        $model = $this->scope->find($id);
        $model->balance = $model->balance + $newValue;
        $model->save();

        // broadcast(new BankAccountBalanceUpdatedEvent($model)); //real-time para o Pusher
        return $model;

    }


    public function decreaseBalance(int $id, float $newValue)
    {
        $model = $this->scope->find($id);
        $model->balance = $model->balance - $newValue;
        $model->save();

        // broadcast(new BankAccountBalanceUpdatedEvent($model)); //real-time para o Pusher
        return $model;
    }
}

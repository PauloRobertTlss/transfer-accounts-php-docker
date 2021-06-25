<?php declare(strict_types=1);

namespace App\Repositories\BankAccount;

use App\Common\Repositories\BaseRepository;
use App\Domain\Financial\BankAccount\Entity\Contract\BankAccount;
use App\Domain\Financial\BankAccount\Repository\BankAccountRepository;
use App\Domain\Financial\Transaction\Entity\Contract\{CategoryPayeeInterface, CategoryPayerInterface};
use App\Domain\Financial\Transaction\Repository\{TransactionPayeeRepository,
    TransactionPayerRepository
};
use App\Models\Financial\BankAccount\BankAccountModel;

/**
 * Class BankAccountRepositoryEloquent
 * @package App\Repositories\BankAccount
 */
final class BankAccountRepositoryEloquent extends BaseRepository implements BankAccountRepository
{
    /**
     * @var TransactionPayerRepository
     */
    private TransactionPayerRepository $payerRepository;
    /**
     * @var TransactionPayeeRepository
     */
    private TransactionPayeeRepository $payeeRepository;

    /**
     * BankAccountRepositoryEloquent constructor.
     * @param TransactionPayerRepository $payerRepository
     * @param TransactionPayeeRepository $payeeRepository
     */
    public function __construct(
        TransactionPayerRepository $payerRepository,
        TransactionPayeeRepository $payeeRepository
    )
    {
        parent::__construct();

        $this->payerRepository = $payerRepository;
        $this->payeeRepository = $payeeRepository;
    }

    public function model(): string
    {
        return BankAccountModel::class;
    }

    public function addBalance(int $id, float $newValue, CategoryPayeeInterface $category): BankAccount
    {
        /** @var BankAccount $model */
        $model = $this->scope->with('client')->find($id);
        $model->balance = $category->operation($model->balance, $newValue);
        $model->save();

        $this->payeeRepository->create([
            'value' => $newValue,
            'category' => $category->identifier(),
            'bank_account_id' => $model->id(),
            'client_done_id' => $model->getClient()->uuid()
        ]);

        // broadcast(new BankAccountBalanceUpdatedEvent($model)); //real-time para o Pusher
        return $model;

    }


    public function decreaseBalance(int $id, float $newValue, CategoryPayerInterface $category): BankAccount
    {
        /** @var BankAccount $model */
        $model = $this->scope->with('client')->find($id);
        $model->balance = $category->operation($model->balance, $newValue);
        $model->save();

        $this->payerRepository->create([
            'value' => $newValue,
            'category' => $category->identifier(),
            'bank_account_id' => $model->id(),
            'client_done_id' => $model->getClient()->uuid()
        ]);

        // broadcast(new BankAccountBalanceUpdatedEvent($model)); //real-time para o Pusher
        return $model;
    }
}

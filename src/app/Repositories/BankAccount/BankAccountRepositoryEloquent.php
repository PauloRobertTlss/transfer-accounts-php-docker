<?php declare(strict_types=1);

namespace App\Repositories\BankAccount;

use App\Common\Repositories\BaseRepository;
use App\Domain\Financial\BankAccount\Entity\Contract\BankAccountInterface;
use App\Domain\Financial\BankAccount\Repository\BankAccountRepositoryInterface;
use App\Domain\Financial\Transaction\Entity\Contract\{CategoryPayeeInterface, CategoryPayerInterface};
use App\Domain\Financial\Transaction\Repository\{TransactionPayeeRepositoryInterface,
    TransactionPayerRepositoryInterface
};
use App\Models\Financial\BankAccount\BankAccountModel;

/**
 * Class BankAccountRepositoryEloquent
 * @package App\Repositories\BankAccount
 */
class BankAccountRepositoryEloquent extends BaseRepository implements BankAccountRepositoryInterface
{
    /**
     * @var TransactionPayerRepositoryInterface
     */
    private TransactionPayerRepositoryInterface $payerRepository;
    /**
     * @var TransactionPayeeRepositoryInterface
     */
    private TransactionPayeeRepositoryInterface $payeeRepository;

    /**
     * BankAccountRepositoryEloquent constructor.
     * @param TransactionPayerRepositoryInterface $payerRepository
     * @param TransactionPayeeRepositoryInterface $payeeRepository
     */
    public function __construct(TransactionPayerRepositoryInterface $payerRepository,
                                TransactionPayeeRepositoryInterface $payeeRepository)
    {
        parent::__construct();

        $this->payerRepository = $payerRepository;
        $this->payeeRepository = $payeeRepository;
    }

    public function model(): string
    {
        return BankAccountModel::class;
    }

    public function addBalance(int $id, float $newValue, CategoryPayeeInterface $category)
    {
        /** @var BankAccountInterface $model */
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


    public function decreaseBalance(int $id, float $newValue, CategoryPayerInterface $category)
    {
        /** @var BankAccountInterface $model */
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

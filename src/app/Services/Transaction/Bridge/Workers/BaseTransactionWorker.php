<?php declare(strict_types=1);

namespace App\Services\Transaction\Bridge\Workers;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Domain\Financial\BankAccount\Repository\BankAccountRepository;
use App\Domain\Financial\Transaction\Entity\Contract\{CategoryPayeeInterface, CategoryPayerInterface};
use App\Domain\Financial\Transaction\Request\TransactionRequest;
use App\Models\CRM\Client\ClientModel;
use App\Services\Transaction\Bridge\Transaction;
use App\Services\Transaction\Policies\TransactionPolicies;
use Illuminate\Support\Facades\DB;

/**
 * Class BaseTransactionWorker
 * @package App\Services\Transaction\Bridge\Workers
 */
abstract class BaseTransactionWorker implements Transaction
{
    abstract protected function categoryPayer(): CategoryPayerInterface;

    abstract protected function categoryPayee(): CategoryPayeeInterface;

    /**
     * @var BankAccountRepository
     */
    private BankAccountRepository $bankAccountRepository;


    /**
     * @var TransactionPolicies
     */
    private TransactionPolicies $transactionPolicies;

    /**
     * BaseTransactionWorker constructor.
     * @param BankAccountRepository $bankAccountRepository
     * @param TransactionPolicies $transactionPolicies
     */
    public function __construct(
        BankAccountRepository $bankAccountRepository,
        TransactionPolicies $transactionPolicies
    )
    {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->transactionPolicies = $transactionPolicies;
    }

    public function payload(TransactionRequest $request): bool
    {
        DB::transaction(function () use ($request) {

            /** @var ClientInterface $clientPayer */
            $clientPayer = ClientModel::with('bankAccount')->find($request->payer());
            /** @var ClientInterface $clientPayee */
            $clientPayee = ClientModel::with('bankAccount')->find($request->payee());
            $bankPayer = $clientPayer->getBankAccount();
            $bankPayee = $clientPayee->getBankAccount();
            /**
             * LOCK - balance
             */
            $bankPayer->lockForUpdate();
            $bankPayee->lockForUpdate();
            $this->transactionPolicies->assertPolicies($request);

            $this->bankAccountRepository->decreaseBalance($bankPayer->id(), $request->value(), $this->categoryPayer());
            $this->bankAccountRepository->addBalance($bankPayee->id(), $request->value(), $this->categoryPayee());

        });
        return true;
    }

}

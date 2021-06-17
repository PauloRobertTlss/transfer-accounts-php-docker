<?php declare(strict_types=1);

namespace App\Services\Transaction\Bridge\Workers;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Domain\Financial\Transaction\Entity\Contract\{CategoryPayeeInterface, CategoryPayerInterface};
use App\Domain\Financial\BankAccount\Repository\BankAccountRepositoryInterface;
use App\Services\Transaction\Policies\TransactionPoliciesInterface;
use App\Domain\Financial\Transaction\Request\TransactionRequestInterface;
use App\Models\CRM\Client\ClientModel;
use App\Services\Transaction\Bridge\TransactionInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class BaseTransactionWorker
 * @package App\Services\Transaction\Bridge\Workers
 */
abstract class BaseTransactionWorker implements TransactionInterface
{
    /**
     * @var BankAccountRepositoryInterface
     */
    private BankAccountRepositoryInterface $bankAccountRepository;
    /**
     * @var TransactionPoliciesInterface
     */
    private TransactionPoliciesInterface $transactionPolicies;

    /**
     * BaseTransactionWorker constructor.
     * @param BankAccountRepositoryInterface $bankAccountRepository
     * @param TransactionPoliciesInterface $transactionPolicies
     */
    public function __construct(
        BankAccountRepositoryInterface $bankAccountRepository,
        TransactionPoliciesInterface $transactionPolicies)
    {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->transactionPolicies = $transactionPolicies;
    }

    abstract protected function categoryPayer(): CategoryPayerInterface;

    abstract protected function categoryPayee(): CategoryPayeeInterface;

    public function payload(TransactionRequestInterface $request)
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
    }

}

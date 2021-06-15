<?php declare(strict_types=1);

namespace App\Services\Transaction\Bridge\Workers;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Domain\Financial\Transaction\Entity\Contract\{CategoryPayeeInterface, CategoryPayerInterface};
use App\Domain\Financial\BankAccount\Repository\BankAccountRepositoryInterface;
use App\Services\Transaction\Policies\TransactionPoliciesInterface;
use App\Domain\Financial\Transaction\Repository\{TransactionPayeeRepositoryInterface,
    TransactionPayerRepositoryInterface
};
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
     * @var TransactionPayerRepositoryInterface
     */
    private TransactionPayerRepositoryInterface $payerRepository;
    /**
     * @var TransactionPayeeRepositoryInterface
     */
    private TransactionPayeeRepositoryInterface $payeeRepository;
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
     * @param TransactionPayerRepositoryInterface $payerRepository
     * @param TransactionPayeeRepositoryInterface $payeeRepository
     * @param TransactionPoliciesInterface $transactionPolicies
     */
    public function __construct(
        BankAccountRepositoryInterface $bankAccountRepository,
        TransactionPayerRepositoryInterface $payerRepository,
        TransactionPayeeRepositoryInterface $payeeRepository,
        TransactionPoliciesInterface $transactionPolicies)
    {
        $this->payerRepository = $payerRepository;
        $this->payeeRepository = $payeeRepository;
        $this->bankAccountRepository = $bankAccountRepository;
        $this->transactionPolicies = $transactionPolicies;
    }

    abstract protected function categoryPayer(): CategoryPayerInterface;

    abstract protected function categoryPayee(): CategoryPayeeInterface;

    public function payload(TransactionRequestInterface $request)
    {

        DB::transaction(function () use ($request) {

            $payload = [
                'payer' => $request->payer(),
                'payee' => $request->payee(),
                'value' => $request->value(),
            ];

            /** @var ClientInterface $clientPayer */
            $clientPayer = ClientModel::with('bankAccount')->find($payload['payer']);
            /** @var ClientInterface $clientPayee */
            $clientPayee = ClientModel::with('bankAccount')->find($payload['payee']);
            $bankPayer = $clientPayer->getBankAccount();
            $bankPayee = $clientPayee->getBankAccount();
            /**
             * LOCK - balance
             */
            $bankPayer->lockForUpdate();
            $bankPayee->lockForUpdate();
            $this->transactionPolicies->assertPolicies($request);

            $value = $payload['value'];
            $this->bankAccountRepository->decreaseBalance($bankPayer->id(), $value);
            $this->bankAccountRepository->addBalance($bankPayee->id(), $value);

            $this->payerRepository->create([
                'value' => $value,
                'category' => $this->categoryPayer()->identifier(),
                'bank_account_id' => $bankPayer->id(),
                'client_done_id' => $clientPayee->uuid()
            ]);

            $this->payeeRepository->create([
                'value' => $value,
                'category' => $this->categoryPayee()->identifier(),
                'bank_account_id' => $bankPayee->id(),
                'client_done_id' => $clientPayer->uuid()
            ]);

        });
    }

}

<?php declare(strict_types=1);

namespace App\Services\Transaction\Bridge\Workers;

use App\Domain\Financial\Transaction\Entity\{CategoryPayeeP2B, CategoryPayerP2B};
use App\Domain\Financial\Transaction\Entity\Contract\{CategoryPayeeInterface, CategoryPayerInterface};

/**
 * Class TransactionWorkerP2B
 * @package App\Services\Transaction\Bridge\Workers
 */
class TransactionWorkerP2B extends BaseTransactionWorker
{

    protected function categoryPayer(): CategoryPayerInterface
    {
        return new CategoryPayerP2B();
    }

    protected function categoryPayee(): CategoryPayeeInterface
    {
        return new CategoryPayeeP2B();
    }
}

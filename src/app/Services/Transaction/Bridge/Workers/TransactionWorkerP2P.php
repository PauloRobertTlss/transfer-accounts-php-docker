<?php declare(strict_types=1);

namespace App\Services\Transaction\Bridge\Workers;

use App\Domain\Financial\Transaction\Entity\Contract\{CategoryPayeeInterface,CategoryPayerInterface};
use App\Domain\Financial\Transaction\Entity\{CategoryPayeeP2P,CategoryPayerP2P};

/**
 * Class TransactionWorkerP2P
 * @package App\Services\Transaction\Bridge\Workers
 */
final class TransactionWorkerP2P extends BaseTransactionWorker
{
    protected function categoryPayer(): CategoryPayerInterface
    {
        return new CategoryPayerP2P();
    }

    protected function categoryPayee(): CategoryPayeeInterface
    {
        return new CategoryPayeeP2P();
    }
}

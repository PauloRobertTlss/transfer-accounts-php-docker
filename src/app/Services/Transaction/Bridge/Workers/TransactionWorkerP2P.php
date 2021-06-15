<?php declare(strict_types=1);

namespace App\Services\Transaction\Bridge\Workers;

use App\Domain\Financial\Transaction\Entity\CategoryPayeeP2P;
use App\Domain\Financial\Transaction\Entity\CategoryPayerP2P;
use App\Domain\Financial\Transaction\Entity\Contract\CategoryPayeeInterface;
use App\Domain\Financial\Transaction\Entity\Contract\CategoryPayerInterface;

/**
 * Class TransactionWorkerP2P
 * @package App\Services\Transaction\Bridge\Workers
 */
class TransactionWorkerP2P extends BaseTransactionWorker
{
    /**
     * @return CategoryPayerInterface
     */
    protected function categoryPayer(): CategoryPayerInterface
    {
        return new CategoryPayerP2P();
    }

    /**
     * @return CategoryPayeeInterface
     */
    protected function categoryPayee(): CategoryPayeeInterface
    {
        return new CategoryPayeeP2P();
    }
}

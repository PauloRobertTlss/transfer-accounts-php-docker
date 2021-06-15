<?php declare(strict_types=1);

namespace App\Services\Transaction\Bridge;
/**
 * Interface BridgerTransactionInterface
 * @package App\Services\Transaction\Bridge
 */
interface BridgerTransactionInterface
{
    /**
     * @param TransactionInterface $work
     * @return mixed
     */
    public function work(TransactionInterface $work);
}

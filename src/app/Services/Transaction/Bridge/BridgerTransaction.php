<?php declare(strict_types=1);

namespace App\Services\Transaction\Bridge;
/**
 * Interface BridgerTransaction
 * @package App\Services\Transaction\Bridge
 */
interface BridgerTransaction
{
    /**
     * @param Transaction $work
     * @return bool
     */
    public function work(Transaction $work): bool;
}

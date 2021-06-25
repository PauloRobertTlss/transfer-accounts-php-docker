<?php declare(strict_types=1);

namespace App\Services\Transaction\Policies;

use App\Domain\Financial\Transaction\Request\TransactionRequest;

/**
 * Interface TransactionPolicies
 * @package App\Services\Transaction\Policies
 */
interface TransactionPolicies
{
    public function assertPolicies(TransactionRequest $transactionRequest): void;
}

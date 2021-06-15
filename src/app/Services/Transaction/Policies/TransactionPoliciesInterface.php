<?php declare(strict_types=1);

namespace App\Services\Transaction\Policies;

use App\Domain\Financial\Transaction\Request\TransactionRequestInterface;

/**
 * Interface TransactionPoliciesInterface
 * @package App\Services\Transaction
 */
interface TransactionPoliciesInterface
{
    /**
     * @param TransactionRequestInterface $request
     * @throw \Exception
     */
    public function assertPolicies(TransactionRequestInterface $request): void;
}

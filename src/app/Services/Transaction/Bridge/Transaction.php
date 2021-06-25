<?php declare(strict_types=1);

namespace App\Services\Transaction\Bridge;

use App\Domain\Financial\Transaction\Request\TransactionRequest;

/**
 * Interface Transaction
 * @package App\Services\Transaction\Bridge
 */
interface Transaction
{
    public function payload(TransactionRequest $request): bool;
}

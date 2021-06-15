<?php declare(strict_types=1);

namespace App\Services\Transaction;

use App\Domain\Financial\Transaction\Request\TransactionRequestInterface;
use App\Domain\Financial\Transaction\Service\TransactionServiceAsyncInterface;
use App\Jobs\Transaction\CreateTransaction;

/**
 * Class TransactionServiceAsync
 * @package App\Services\Transaction
 */
class TransactionServiceAsync implements TransactionServiceAsyncInterface
{
    /**
     * @param TransactionRequestInterface $request
     * @return bool
     */
    public function store(TransactionRequestInterface $request): array
    {
        CreateTransaction::dispatchAfterResponse($request);
        return ['message' => 'started queues'];

    }
}

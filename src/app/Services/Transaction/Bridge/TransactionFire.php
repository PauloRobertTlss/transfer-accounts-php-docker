<?php declare(strict_types=1);

namespace App\Services\Transaction\Bridge;

use App\Domain\Financial\Transaction\Request\TransactionRequest;

/**
 * Class TransactionFire
 * @package App\Services\Transaction\Bridge
 */
final class TransactionFire implements BridgerTransaction
{
    /**
     * @var TransactionRequest
     */
    private TransactionRequest $request;

    /**
     * TransactionFire constructor.
     * @param TransactionRequest $request
     */
    public function __construct(TransactionRequest $request)
    {
        $this->request = $request;
    }

    public function work(Transaction $work): bool
    {
        return $work->payload($this->request);
    }
}

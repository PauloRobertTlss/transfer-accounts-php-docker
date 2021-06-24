<?php declare(strict_types=1);

namespace App\Services\Transaction;

use App\Common\ManageRule\ManageRulesInterface;
use App\Domain\Financial\Transaction\Request\TransactionRequest;
use App\Domain\Financial\Transaction\Service\TransactionServiceAsync as TransactionServiceAsyncContract;
use App\Jobs\Transaction\CreateTransaction;

/**
 * Class TransactionServiceAsync
 * @package App\Services\Transaction
 */
final class TransactionServiceAsync implements TransactionServiceAsyncContract
{
    /**
     * @var ManageRulesInterface
     */
    private ManageRulesInterface $manageRules;

    /**
     * TransactionServiceAsync constructor.
     * @param ManageRulesInterface $manageRules
     */
    public function __construct(ManageRulesInterface $manageRules)
    {
        $this->manageRules = $manageRules;
    }

    /**
     * @param TransactionRequest $request
     * @return array
     */
    public function store(TransactionRequest $request): array
    {
        CreateTransaction::dispatchAfterResponse($request, $this->manageRules);
        return ['message' => 'started queues'];

    }
}

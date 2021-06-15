<?php declare(strict_types=1);

namespace App\Services\Transaction;

use App\Common\ManageRule\ManageRulesInterface;
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
     * @param TransactionRequestInterface $request
     * @return bool
     */
    public function store(TransactionRequestInterface $request): array
    {
        CreateTransaction::dispatchAfterResponse($request,$this->manageRules);
        return ['message' => 'started queues'];

    }
}

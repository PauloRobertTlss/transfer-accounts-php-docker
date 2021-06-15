<?php declare(strict_types=1);

namespace App\Services\Transaction\Bridge;

use App\Domain\Financial\Transaction\Request\TransactionRequestInterface;

/**
 * Class TransactionFire
 * @package App\Services\Transaction\Bridge
 */
class TransactionFire implements BridgerTransactionInterface
{
    /**
     * @var TransactionRequestInterface
     */
    private $request;

    /**
     * TransactionP2P constructor.
     * @param TransactionRequestInterface $request
     */
    public function __construct(TransactionRequestInterface $request)
    {
        $this->request = $request;
    }

    public function work(TransactionInterface $work)
    {
        return $work->payload($this->request);
    }
}

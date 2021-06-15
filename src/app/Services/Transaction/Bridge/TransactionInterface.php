<?php declare(strict_types=1);

namespace App\Services\Transaction\Bridge;

use App\Domain\Financial\Transaction\Request\TransactionRequestInterface;

/**
 * Interface TransactionInterface
 * @package App\Services\Transaction\Bridge
 */
interface TransactionInterface
{
    /**
     * @param TransactionRequestInterface $request
     * @return mixed
     */
    public function payload(TransactionRequestInterface $request);
}

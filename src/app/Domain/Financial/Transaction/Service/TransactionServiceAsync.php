<?php declare(strict_types=1);

namespace App\Domain\Financial\Transaction\Service;

use App\Domain\Financial\Transaction\Request\TransactionRequest;

interface TransactionServiceAsync
{
    /**
     * @param TransactionRequest $args
     * @return array
     */
    public function store(TransactionRequest $args): array;
}

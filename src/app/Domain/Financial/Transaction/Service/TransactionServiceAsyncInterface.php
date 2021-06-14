<?php declare(strict_types=1);

namespace App\Domain\Financial\Transaction\Service;

use App\Domain\Financial\Transaction\Request\TransactionRequestInterface;

interface TransactionServiceAsyncInterface
{
    /**
     * @param TransactionRequestInterface $args
     * @return array
     */
    public function store(TransactionRequestInterface $args): array;
}

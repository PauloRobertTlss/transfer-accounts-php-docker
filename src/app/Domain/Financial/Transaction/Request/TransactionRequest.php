<?php declare(strict_types=1);

namespace App\Domain\Financial\Transaction\Request;

interface TransactionRequest
{
    public function value(): float;

    public function payee(): string;

    public function payer(): string;
}

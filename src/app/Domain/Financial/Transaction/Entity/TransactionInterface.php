<?php declare(strict_types=1);

namespace App\Domain\Financial;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Domain\Resource\TimestampUidInterface;

interface TransactionInterface extends TimestampUidInterface
{
    public function value(): float;

    public function bankAccount(): BankAccountInterface;

    public function category(): CategoryInterface;

    public function client(): ClientInterface;

}

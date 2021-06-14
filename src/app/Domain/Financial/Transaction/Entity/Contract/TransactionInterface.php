<?php declare(strict_types=1);

namespace App\Domain\Financial\Transaction\Entity\Contract;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Domain\Financial\BankAccount\Entity\Contract\BankAccountInterface;
use App\Domain\Resource\TimestampUidInterface;

interface TransactionInterface extends TimestampUidInterface
{
    public function getValue(): float;

    public function getBankAccount(): BankAccountInterface;

    public function getClient(): ClientInterface;

}

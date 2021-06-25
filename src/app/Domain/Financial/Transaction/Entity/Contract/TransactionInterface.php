<?php declare(strict_types=1);

namespace App\Domain\Financial\Transaction\Entity\Contract;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Domain\Financial\BankAccount\Entity\Contract\BankAccount;
use App\Domain\Resource\Timestamp;

interface TransactionInterface extends Timestamp
{
    public function getValue(): float;

    public function getBankAccount(): BankAccount;

    public function getClient(): ClientInterface;

}

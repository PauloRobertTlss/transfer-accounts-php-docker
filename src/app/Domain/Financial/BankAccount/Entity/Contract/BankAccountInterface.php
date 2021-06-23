<?php declare(strict_types=1);

namespace App\Domain\Financial\BankAccount\Entity\Contract;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Domain\Resource\ResourceIdInterface;
use App\Domain\Resource\ResourceUidInterface;

interface BankAccountInterface extends ResourceIdInterface
{
    public const TABLE = 'bank_accounts';

    public function getAgency(): string;

    public function getAccount(): string;

    public function getBalance(): float;

    public function getClient(): ClientInterface;

}

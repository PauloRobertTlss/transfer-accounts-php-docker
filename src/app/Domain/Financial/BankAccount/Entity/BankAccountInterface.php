<?php declare(strict_types=1);

namespace App\Domain\Financial;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Domain\Resource\ResourceUidInterface;

interface BankAccountInterface extends ResourceUidInterface
{
    public function name(): string;

    public function agency(): string;

    public function account(): string;

    public function default(): bool;

    public function balance(): float;

    public function client(): ClientInterface;

}

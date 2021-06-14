<?php declare(strict_types=1);

namespace App\Domain\CRM\Client\Entity;

use App\Domain\Financial\BankAccount\Entity\Contract\BankAccountInterface;
use App\Domain\Resource\ResourceUidInterface;

interface ClientInterface extends ResourceUidInterface
{
    public function getName(): string;

    public function getDocument();

    public function getBankAccount(): BankAccountInterface;
}

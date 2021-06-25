<?php declare(strict_types=1);

namespace App\Domain\CRM\Client\Entity;

use App\Domain\Financial\BankAccount\Entity\Contract\BankAccount;
use App\Domain\Resource\ResourceUidInterface;

interface ClientInterface extends ResourceUidInterface
{
    public const TABLE = 'clients';

    public function getName(): string;

    public function getDocument();

    public function getBankAccount(): BankAccount;
}

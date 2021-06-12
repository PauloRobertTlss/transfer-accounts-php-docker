<?php declare(strict_types=1);

namespace App\Domain\Financial;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Domain\Resource\ResourceUidInterface;

interface UserInterface extends ResourceUidInterface
{
    public function email(): string;

    public function client(): ClientInterface;

}

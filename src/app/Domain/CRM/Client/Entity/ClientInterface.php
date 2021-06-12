<?php declare(strict_types=1);

namespace App\Domain\CRM\Client\Entity;

use App\Domain\Resource\ResourceUidInterface;

interface ClientInterface extends ResourceUidInterface
{
    public function name(): string;
}

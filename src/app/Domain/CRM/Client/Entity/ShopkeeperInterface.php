<?php declare(strict_types=1);

namespace App\Domain\CRM\Client\Entity;

interface ShopkeeperInterface extends ClientInterface
{
    public function cnpj(): string;
}

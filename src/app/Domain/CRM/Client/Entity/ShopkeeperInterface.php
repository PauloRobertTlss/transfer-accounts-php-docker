<?php declare(strict_types=1);

namespace App\Domain\CRM\Client\Entity;

interface ShopkeeperInterface
{
    public const TABLE = 'shopkeepers';

    public function cnpj(): string;
}

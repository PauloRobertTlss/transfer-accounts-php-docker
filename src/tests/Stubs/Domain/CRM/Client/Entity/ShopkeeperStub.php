<?php declare(strict_types=1);

namespace Tests\Stubs\Domain\CRM\Client\Entity;

use App\Domain\CRM\Client\Entity\ShopkeeperInterface;

class ShopkeeperStub implements ShopkeeperInterface
{

    public function cnpj(): string
    {
        return 'stub';
    }
}

<?php declare(strict_types=1);

namespace Tests\Stubs\Domain\CRM\Client\Entity;

use App\Domain\CRM\Client\Entity\Shopkeeper;

class ShopkeeperStub implements Shopkeeper
{

    public function cnpj(): string
    {
        return 'stub';
    }
}

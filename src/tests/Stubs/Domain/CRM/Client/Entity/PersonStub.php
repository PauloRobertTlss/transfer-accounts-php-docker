<?php declare(strict_types=1);

namespace Tests\Stubs\Domain\CRM\Client\Entity;

use App\Domain\CRM\Client\Entity\PersonInterface;

class PersonStub implements PersonInterface
{
    public function cpf(): string
    {
        return 'stub';
    }
}

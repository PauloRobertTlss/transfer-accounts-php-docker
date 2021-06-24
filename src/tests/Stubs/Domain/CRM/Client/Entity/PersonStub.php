<?php declare(strict_types=1);

namespace Tests\Stubs\Domain\CRM\Client\Entity;

use App\Domain\CRM\Client\Entity\Person;

class PersonStub implements Person
{
    public function cpf(): string
    {
        return 'stub';
    }
}

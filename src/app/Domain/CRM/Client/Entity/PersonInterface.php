<?php declare(strict_types=1);

namespace App\Domain\CRM\Client\Entity;

interface PersonInterface
{
    public const TABLE = 'persons';

    public function cpf(): string;
}

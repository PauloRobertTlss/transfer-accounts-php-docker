<?php declare(strict_types=1);

namespace App\Domain\CRM\Client\Entity;

interface PersonInterface
{
    public function cpf(): string;
}

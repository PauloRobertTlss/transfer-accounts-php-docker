<?php declare(strict_types=1);

namespace App\Domain\CRM\Client\Entity;

interface PersonInterface extends ClientInterface
{
    public function cpf(): string;
}

<?php declare(strict_types=1);

namespace App\Domain\Financial\Transaction\Entity\Contract;

interface CategoryInterface
{
    public function identifier(): string;
}

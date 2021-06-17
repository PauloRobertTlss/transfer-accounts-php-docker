<?php declare(strict_types=1);

namespace App\Domain\Financial\Transaction\Entity\Contract;

interface CategoryInterface
{
    /**
     * @return string
     */
    public function identifier(): string;

    /**
     * @param float $balance
     * @param float $newValue
     * @return float
     */
    public function operation(float $balance, float $newValue): float;
}

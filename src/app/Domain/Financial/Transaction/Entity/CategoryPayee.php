<?php declare(strict_types=1);

namespace App\Domain\Financial\Transaction\Entity;

use App\Domain\Financial\Transaction\Entity\Contract\CategoryPayeeInterface;

abstract class CategoryPayee implements CategoryPayeeInterface
{
    /**
     * @param float $balance
     * @param $newValue
     * @return float
     */
    public function operation(float $balance, $newValue) : float
    {
        return $balance + $newValue;
    }
}

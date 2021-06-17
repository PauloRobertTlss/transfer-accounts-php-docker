<?php declare(strict_types=1);

namespace App\Domain\Financial\BankAccount\Repository;

use App\Domain\Financial\Transaction\Entity\Contract\{CategoryPayeeInterface,CategoryPayerInterface};

/**
 * Interface BankAccountRepositoryInterface
 * @package App\Domain\Financial\BankAccount\Repository
 */
interface BankAccountRepositoryInterface
{
    /**
     * @param int $id
     * @param float $value
     * @param CategoryPayeeInterface $category
     * @return mixed
     */
    public function addBalance(int $id, float $value, CategoryPayeeInterface $category);

    /**
     * @param int $id
     * @param float $value
     * @param CategoryPayerInterface $category
     * @return mixed
     */
    public function decreaseBalance(int $id, float $value, CategoryPayerInterface $category);

}

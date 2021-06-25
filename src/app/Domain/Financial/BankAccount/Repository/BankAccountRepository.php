<?php declare(strict_types=1);

namespace App\Domain\Financial\BankAccount\Repository;

use App\Domain\Financial\BankAccount\Entity\Contract\BankAccount;
use App\Domain\Financial\Transaction\Entity\Contract\{CategoryPayeeInterface, CategoryPayerInterface};

/**
 * Interface BankAccountRepository
 * @package App\Domain\Financial\BankAccount\Repository
 */
interface BankAccountRepository
{
    /**
     * @param int $id
     * @param float $value
     * @param CategoryPayeeInterface $category
     * @return BankAccount
     */
    public function addBalance(int $id, float $value, CategoryPayeeInterface $category): BankAccount;

    /**
     * @param int $id
     * @param float $value
     * @param CategoryPayerInterface $category
     * @return BankAccount
     */
    public function decreaseBalance(int $id, float $value, CategoryPayerInterface $category): BankAccount;

}

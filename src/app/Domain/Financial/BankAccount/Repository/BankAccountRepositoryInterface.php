<?php declare(strict_types=1);

namespace App\Domain\Financial\BankAccount\Repository;

interface BankAccountRepositoryInterface
{

    public function addBalance(int $id, float $value);

    public function decreaseBalance(int $id, float $value);

}

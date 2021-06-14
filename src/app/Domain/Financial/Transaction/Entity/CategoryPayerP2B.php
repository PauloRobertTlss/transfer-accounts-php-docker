<?php declare(strict_types=1);

namespace App\Domain\Financial\Transaction\Entity;

use App\Domain\Financial\Transaction\Entity\Contract\CategoryPayerP2BInterface;

class CategoryPayerP2B implements CategoryPayerP2BInterface
{
    public const IDENTIFIER = '1c7b2716-2904-47e0-9642-6c15870e2f50';

    public function identifier(): string
    {
        return self::IDENTIFIER;
    }
}

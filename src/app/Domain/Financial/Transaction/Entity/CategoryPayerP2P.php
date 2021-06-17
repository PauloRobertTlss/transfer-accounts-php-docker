<?php declare(strict_types=1);

namespace App\Domain\Financial\Transaction\Entity;

use App\Domain\Financial\Transaction\Entity\Contract\CategoryPayerP2PInterface;

class CategoryPayerP2P extends CategoryPayer implements CategoryPayerP2PInterface
{
    public const IDENTIFIER = '923191b1-ebe0-4292-957f-d6674fc9f336';

    public function identifier(): string
    {
        return self::IDENTIFIER;
    }
}

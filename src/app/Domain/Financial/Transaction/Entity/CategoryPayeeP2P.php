<?php declare(strict_types=1);


namespace App\Domain\Financial\Transaction\Entity;

use App\Domain\Financial\Transaction\Entity\Contract\CategoryPayeeP2PInterface;

class CategoryPayeeP2P implements CategoryPayeeP2PInterface
{
    public const IDENTIFIER = '6fa44502-1ebc-4de8-b834-e4dd10a9651b';

    public function identifier(): string
    {
        return self::IDENTIFIER;
    }
}

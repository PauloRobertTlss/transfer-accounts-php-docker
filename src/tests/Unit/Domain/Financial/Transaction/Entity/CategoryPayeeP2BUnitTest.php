<?php declare(strict_types=1);

namespace Tests\Unit\Domain\Financial\Transaction\Entity;

use App\Domain\Financial\Transaction\Entity\CategoryPayeeP2B;

/**
 * Class CategoryPayeeP2BUnitTest
 * @package Tests\Unit\Domain\Financial\Transaction\Entity
 */
class CategoryPayeeP2BUnitTest extends CategoryPayeeUnitTest
{
    public function testInstanceResponsible(): void
    {
        $this->assertInstance();
        $this->assertOperations(1000,1542);
    }

    public function category(): string
    {
        return CategoryPayeeP2B::class;
    }
}

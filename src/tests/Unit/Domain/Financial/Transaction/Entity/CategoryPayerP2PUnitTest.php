<?php declare(strict_types=1);

namespace Tests\Unit\Domain\Financial\Transaction\Entity;

use App\Domain\Financial\Transaction\Entity\CategoryPayerP2P;

class CategoryPayerP2PUnitTest extends BaseCategoryPayerUnitTest
{

    public function testInstanceResponsible(): void
    {
        $this->assertInstance();
        $this->assertOperations(1000,1542);
    }

    public function category(): string
    {
        return CategoryPayerP2P::class;
    }
}

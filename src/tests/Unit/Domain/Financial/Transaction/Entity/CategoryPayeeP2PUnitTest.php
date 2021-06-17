<?php declare(strict_types=1);

namespace Tests\Unit\Domain\Financial\Transaction\Entity;


use App\Domain\Financial\Transaction\Entity\CategoryPayeeP2P;

class CategoryPayeeP2PUnitTest extends CategoryPayeeUnitTest
{
    public function testInstanceResponsible(): void
    {
        $this->assertInstance();
        $this->assertOperations(1000,1542);
    }

    public function category(): string
    {
        return CategoryPayeeP2P::class;
    }

}

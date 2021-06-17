<?php declare(strict_types=1);

namespace Tests\Unit\Domain\Financial\Transaction\Entity;

use App\Domain\Financial\Transaction\Entity\Contract\CategoryPayeeInterface;
use PHPUnit\Framework\TestCase;

abstract class BaseCategoryPayerUnitTest extends TestCase
{
    /**
     * @return string
     */
    abstract public function category(): string;

    public function assertInstance(): void
    {
        $onError = false;
        try {
            $class = $this->category();
            (new $class());
        } catch (\Exception $exception) {
            $onError = true;
        }

        $this->assertFalse($onError);
    }

    public function assertOperations(float $valueOne, float $valueTwo):void
    {
        /** @var CategoryPayeeInterface $class */
        $class = $this->category();
        $result = (new $class())->operation($valueOne, $valueTwo);

        $this->assertEquals(($valueOne - $valueTwo), $result);

    }
}

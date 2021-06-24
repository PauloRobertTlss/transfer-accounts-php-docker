<?php

namespace Tests\Unit\Models\CRM;

use App\Domain\CRM\Client\Entity\Shopkeeper;
use App\Models\CRM\Client\ShopkeeperModel;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

/**
 * Class ShopkeeperUnitTest
 * @package Tests\Unit\Models\CRM
 */
class ShopkeeperUnitTest extends TestCase
{
    /**
     * @var Shopkeeper
     */
    private Shopkeeper $shopKeeperModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->shopKeeperModel = new ShopkeeperModel();
    }

    public function testIfExtendsModelFromEloquent(): void
    {
        self::assertInstanceOf(Model::class, $this->shopKeeperModel);
    }

    public function testObjectType(): void
    {
        self::assertInstanceOf(Shopkeeper::class, $this->shopKeeperModel);
    }

    public function testFillableAttribute(): void
    {
        $fillable = [
            'id',
            'document'
        ];

        self::assertEquals($fillable, $this->shopKeeperModel->getFillable());
    }

    public function testIncrementing(): void
    {
        self::assertTrue($this->shopKeeperModel->incrementing);
    }

    public function testTimestamp(): void
    {
        self::assertFalse($this->shopKeeperModel->timestamps);
    }

    public function testTable(): void
    {
        $reflectionClass = new \ReflectionClass(ShopkeeperModel::class);
        $reflectionProperty = $reflectionClass->getProperty('table');
        $reflectionProperty->setAccessible(true);

        $table = $reflectionProperty->getValue($this->shopKeeperModel);
        self::assertEquals(Shopkeeper::TABLE, $table);
    }

    public function testKeyType(): void
    {
        $reflectionClass = new \ReflectionClass(ShopkeeperModel::class);
        $reflectionProperty = $reflectionClass->getProperty('keyType');
        $reflectionProperty->setAccessible(true);

        $keyType = $reflectionProperty->getValue($this->shopKeeperModel);
        self::assertEquals('int', $keyType);
    }
}

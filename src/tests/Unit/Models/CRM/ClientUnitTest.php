<?php

namespace Tests\Unit\Models\CRM;

use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Models\CRM\Client\ClientModel;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

/**
 * Class ClientUnitTest
 * @package Tests\Unit\Models\CRM
 */
class ClientUnitTest extends TestCase
{
    /**
     * @var ClientInterface
     */
    private ClientInterface $clientModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->clientModel = new ClientModel();
    }

    public function testIfExtendsModelFromEloquent(): void
    {
        self::assertInstanceOf(Model::class, $this->clientModel);
    }

    public function testObjectType(): void
    {
        self::assertInstanceOf(ClientInterface::class, $this->clientModel);
    }

    public function testFillableAttribute(): void
    {
        $fillable = [
            'id',
            'name',
            'document_type',
            'document_id'
        ];

        self::assertEquals($fillable, $this->clientModel->getFillable());
    }

    public function testCastsAttribute(): void
    {
        $casts = ['id' => 'string'];

        self::assertEquals($casts, $this->clientModel->getCasts());
    }

    public function testIncrementing(): void
    {
        self::assertFalse($this->clientModel->incrementing);
    }

    public function testTimestamp(): void
    {
        self::assertFalse($this->clientModel->timestamps);
    }

    public function testTable(): void
    {
        $reflectionClass = new \ReflectionClass(ClientModel::class);
        $reflectionProperty = $reflectionClass->getProperty('table');
        $reflectionProperty->setAccessible(true);

        $table = $reflectionProperty->getValue($this->clientModel);
        self::assertEquals(ClientInterface::TABLE, $table);
    }

    public function testKeyType(): void
    {
        $reflectionClass = new \ReflectionClass(ClientModel::class);
        $reflectionProperty = $reflectionClass->getProperty('keyType');
        $reflectionProperty->setAccessible(true);

        $keyType = $reflectionProperty->getValue($this->clientModel);
        self::assertEquals('string', $keyType);
    }
}

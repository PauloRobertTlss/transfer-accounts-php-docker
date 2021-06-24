<?php

namespace Tests\Unit\Models\CRM;

use App\Domain\CRM\Client\Entity\Person;
use App\Models\CRM\Client\PersonModel;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

/**
 * Class PersonUnitTest
 * @package Tests\Unit\Models\CRM
 */
class PersonUnitTest extends TestCase
{
    /**
     * @var Person
     */
    private Person $personModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->personModel = new PersonModel();
    }

    public function testIfExtendsModelFromEloquent(): void
    {
        self::assertInstanceOf(Model::class, $this->personModel);
    }

    public function testObjectType(): void
    {
        self::assertInstanceOf(Person::class, $this->personModel);
    }

    public function testFillableAttribute(): void
    {
        $fillable = [
            'id',
            'document'
        ];

        self::assertEquals($fillable, $this->personModel->getFillable());
    }

    public function testIncrementing(): void
    {
        self::assertTrue($this->personModel->incrementing);
    }

    public function testTimestamp(): void
    {
        self::assertFalse($this->personModel->timestamps);
    }

    public function testTable(): void
    {
        $reflectionClass = new \ReflectionClass(PersonModel::class);
        $reflectionProperty = $reflectionClass->getProperty('table');
        $reflectionProperty->setAccessible(true);

        $table = $reflectionProperty->getValue($this->personModel);
        self::assertEquals(Person::TABLE, $table);
    }

    public function testKeyType(): void
    {
        $reflectionClass = new \ReflectionClass(PersonModel::class);
        $reflectionProperty = $reflectionClass->getProperty('keyType');
        $reflectionProperty->setAccessible(true);

        $keyType = $reflectionProperty->getValue($this->personModel);
        self::assertEquals('int', $keyType);
    }
}

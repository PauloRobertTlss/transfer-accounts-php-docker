<?php declare(strict_types=1);

namespace Tests\Unit\Models\Financial\BankAccount;

use App\Domain\Financial\BankAccount\Entity\Contract\BankAccountInterface;
use App\Models\Financial\BankAccount\BankAccountModel;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class BankAccountModelUnitTest extends TestCase
{
    /**
     * @var BankAccountInterface
     */
    private BankAccountInterface $clientModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientModel = new BankAccountModel();
    }

    public function testIfExtendsModelFromEloquent(): void
    {
        self::assertInstanceOf(Model::class, $this->clientModel);
    }

    public function testObjectType(): void
    {
        self::assertInstanceOf(BankAccountInterface::class, $this->clientModel);
    }

    public function testFillableAttribute(): void
    {
        $fillable = [
            'agency',
            'account',
            'balance',
            'client_id'
        ];

        self::assertEquals($fillable, $this->clientModel->getFillable());
    }

    public function testCastsAttribute(): void
    {
        $casts = [
            'balance' => 'float',
            'client_id' => 'string',
            'id' => 'int'

        ];

        self::assertEquals($casts, $this->clientModel->getCasts());
    }

    public function testIncrementing(): void
    {
        self::assertTrue($this->clientModel->incrementing);
    }

    public function testTimestamp(): void
    {
        self::assertFalse($this->clientModel->timestamps);
    }

    public function testTable(): void
    {
        $reflectionClass = new \ReflectionClass(BankAccountModel::class);
        $reflectionProperty = $reflectionClass->getProperty('table');
        $reflectionProperty->setAccessible(true);

        $table = $reflectionProperty->getValue($this->clientModel);
        self::assertEquals(BankAccountInterface::TABLE, $table);
    }

    public function testKeyType(): void
    {
        $reflectionClass = new \ReflectionClass(BankAccountModel::class);
        $reflectionProperty = $reflectionClass->getProperty('keyType');
        $reflectionProperty->setAccessible(true);

        $keyType = $reflectionProperty->getValue($this->clientModel);
        self::assertEquals('int', $keyType);
    }
}

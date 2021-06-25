<?php declare(strict_types=1);

namespace Tests\Unit\Models\Financial\Transaction;

use App\Domain\Financial\Transaction\Entity\Contract\TransactionPayee;
use App\Domain\Financial\Transaction\Entity\Contract\TransactionPayer;
use PHPUnit\Framework\TestCase;

abstract class BaseTransactionUnitTest extends TestCase
{
    /**
     * @var TransactionPayee|TransactionPayer
     */
    private $transaction;

    abstract protected function instance(): string;

    abstract protected function transactionInterface(): string;

    abstract protected function table(): string;

    protected function setUp(): void
    {
        parent::setUp();
        $class = $this->instance();
        $this->transaction = new $class();
    }

    public function testIfExtendsModelFromEloquent(): void
    {
        self::assertInstanceOf($this->transactionInterface(), $this->transaction);
    }

    public function testObjectType(): void
    {
        self::assertInstanceOf($this->transactionInterface(), $this->transaction);
    }

    public function testFillableAttribute(): void
    {
        $fillable = [
            'id',
            'value',
            'category',
            'bank_account_id',
            'client_done_id'
        ];

        self::assertEquals($fillable, $this->transaction->getFillable());
    }

    public function testCastsAttribute(): void
    {
        $casts = [
            'value' => 'float',
            'id' => 'int'
        ];

        self::assertEquals($casts, $this->transaction->getCasts());
    }

    public function testIncrementing(): void
    {
        self::assertTrue($this->transaction->incrementing);
    }

    public function testTimestamp(): void
    {
        self::assertFalse($this->transaction->timestamps);
    }

    public function testTable(): void
    {
        $reflectionClass = new \ReflectionClass($this->instance());
        $reflectionProperty = $reflectionClass->getProperty('table');
        $reflectionProperty->setAccessible(true);

        $table = $reflectionProperty->getValue($this->transaction);
        self::assertEquals($this->table(), $table);
    }

    public function testKeyType(): void
    {
        $reflectionClass = new \ReflectionClass($this->instance());
        $reflectionProperty = $reflectionClass->getProperty('keyType');
        $reflectionProperty->setAccessible(true);

        $keyType = $reflectionProperty->getValue($this->transaction);
        self::assertEquals('int', $keyType);
    }

}

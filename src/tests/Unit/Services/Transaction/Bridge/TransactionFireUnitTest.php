<?php declare(strict_types=1);

namespace Tests\Unit\Services\Transaction\Bridge;

use App\Domain\Financial\Transaction\Request\TransactionRequestInterface;
use App\Services\Transaction\Bridge\BridgerTransactionInterface;
use App\Services\Transaction\Bridge\TransactionFire;
use PHPUnit\Framework\TestCase;


class TransactionFireUnitTest extends TestCase
{

    /**
     * @var TransactionRequestInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    public TransactionRequestInterface $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = $this->getMockBuilder(TransactionRequestInterface::class)->getMock();

    }

    public function testInstance(): void
    {
        $onError = false;
        try {
            (new TransactionFire($this->request));
        } catch (\Exception $exception) {
            $onError = true;
        }

        $this->assertFalse($onError);
    }

    public function testObjectType(): void
    {
        $instance = new TransactionFire($this->request);
        $this->assertInstanceOf(BridgerTransactionInterface::class, $instance);
    }

    public function testFillFieldRequest(): void
    {
        $reflectionClass = new \ReflectionClass(TransactionFire::class);
        $reflectionProperty = $reflectionClass->getProperty('request');
        $reflectionProperty->setAccessible(true);

        $request = $reflectionProperty->getValue(new TransactionFire($this->request));
        $this->assertNotEmpty($request);

    }


}

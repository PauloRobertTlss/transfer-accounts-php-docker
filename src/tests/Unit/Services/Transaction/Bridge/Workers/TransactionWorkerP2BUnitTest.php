<?php declare(strict_types=1);

namespace Tests\UnitServices\Transaction\Bridge\Workers;

use App\Domain\Financial\BankAccount\Repository\BankAccountRepositoryInterface;
use App\Domain\Financial\Transaction\Request\TransactionRequestInterface;
use App\Services\Transaction\Bridge\TransactionInterface;
use App\Services\Transaction\Bridge\Workers\BaseTransactionWorker;
use App\Services\Transaction\Bridge\Workers\TransactionWorkerP2B;
use App\Services\Transaction\Policies\TransactionPoliciesInterface;
use Tests\TestCase;

/**
 * Class TransactionWorkerP2BUnitTest
 * @package Tests\UnitServices\Transaction\Bridge\Workers
 */
class TransactionWorkerP2BUnitTest extends TestCase
{
    /**
     * @var TransactionRequestInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    public TransactionRequestInterface $request;
    private \PHPUnit\Framework\MockObject\MockObject $bankRepository;
    private \PHPUnit\Framework\MockObject\MockObject $servicePolicies;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = $this->getMockBuilder(TransactionRequestInterface::class)->getMock();
        $this->bankRepository = $this->getMockBuilder(BankAccountRepositoryInterface::class)->getMock();
        $this->servicePolicies = $this->getMockBuilder(TransactionPoliciesInterface::class)->getMock();

    }

    public function testInstance(): void
    {
        $onError = false;
        try {
            (new TransactionWorkerP2B($this->bankRepository, $this->servicePolicies));
        } catch (\Exception $exception) {
            $onError = true;
        }

        $this->assertFalse($onError);

    }

    public function testisExtendsOfBaseTransactionWorker(): void
    {
        $instance = new TransactionWorkerP2B($this->bankRepository, $this->servicePolicies);
        $this->assertInstanceOf(BaseTransactionWorker::class, $instance);
        $this->assertInstanceOf(TransactionInterface::class, $instance);
    }
}

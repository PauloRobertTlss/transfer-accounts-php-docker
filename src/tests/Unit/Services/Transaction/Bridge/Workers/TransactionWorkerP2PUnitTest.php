<?php declare(strict_types=1);

namespace Tests\Unit\Services\Transaction\Bridge\Workers;

use App\Domain\Financial\BankAccount\Repository\BankAccountRepository;
use App\Domain\Financial\Transaction\Request\TransactionRequest;
use App\Services\Transaction\Bridge\Transaction;
use App\Services\Transaction\Bridge\Workers\{BaseTransactionWorker, TransactionWorkerP2P};
use App\Services\Transaction\Policies\TransactionPolicies;
use Tests\TestCase;

/**
 * Class TransactionWorkerP2PUnitTest
 * @package Tests\Unit\Services\Transaction\Bridge\Workers
 */
class TransactionWorkerP2PUnitTest extends TestCase
{
    /**
     * @var TransactionRequest|\PHPUnit\Framework\MockObject\MockObject
     */
    public TransactionRequest $request;
    private \PHPUnit\Framework\MockObject\MockObject $bankRepository;
    private \PHPUnit\Framework\MockObject\MockObject $servicePolicies;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = $this->getMockBuilder(TransactionRequest::class)->getMock();
        $this->bankRepository = $this->getMockBuilder(BankAccountRepository::class)->getMock();
        $this->servicePolicies = $this->getMockBuilder(TransactionPolicies::class)->getMock();

    }

    public function testInstance(): void
    {
        $onError = false;
        try {
            (new TransactionWorkerP2P($this->bankRepository, $this->servicePolicies));
        } catch (\Exception $exception) {
            $onError = true;
        }

        $this->assertFalse($onError);

    }

    public function testisExtendsOfBaseTransactionWorker(): void
    {
        $instance = new TransactionWorkerP2P($this->bankRepository, $this->servicePolicies);
        $this->assertInstanceOf(BaseTransactionWorker::class, $instance);
        $this->assertInstanceOf(Transaction::class, $instance);
    }

}

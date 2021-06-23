<?php

namespace Tests\Feature\Http\Controllers\Api\Transactions;


use App\Domain\Financial\Transaction\Service\TransactionServiceAsyncInterface;
use App\ExternalAuthorization\ExternalAuthorizationInterface;
use App\Http\Controllers\Api\TransactionsController;
use App\Http\Requests\Transaction\TransactionRequest;
use App\Models\Financial\BankAccount\BankAccountModel;
use App\Models\Financial\Transaction\TransactionPayee;
use App\Models\Financial\Transaction\TransactionPayer;
use App\Common\ManageRule\Exceptions\NoAllowedShopKeeperRuleException;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\Lang;
use Ramsey\Uuid\Uuid;
use Tests\Stubs\ExternalAuthorization\ExternalValidatorSuccessStub;

class TransactionsControllersTest extends BaseTransactions
{

    protected function setUp(): void
    {
        parent::setUp();
        /**
         * Force stub
         */
        $this->instance(ExternalAuthorizationInterface::class, new ExternalValidatorSuccessStub());

    }


    public function testiInValidationRequired()
    {
        $sentData = ['value' => 0, 'payer' => null, 'payee' => null];
        $response = $this->postJson(route('transfer.create'), $sentData);

        $this->assertInvalidationFields($response, ['payer', 'payee'], 'required');
        $this->assertInvalidationFields($response, ['value'], 'min.numeric', ['min' => 1]);


    }

    public function testExistsClientDB()
    {
        $uid = Uuid::uuid4()->toString();

        $sentData = ['value' => 100, 'payer' => $uid, 'payee' => $uid];
        $response = $this->postJson(route('transfer.create'), $sentData);

        $this->assertInvalidationFields($response, ['payer', 'payee'], 'exists');

    }

    public function testStoreTransactionP2P()
    {
        [$idPersonOne, $idPersonTwo] = $this->startedTransactionP2P();

        $response = $this->postJson(route('transfer.create'), ['value' => 999, 'payer' => $idPersonOne, 'payee' => $idPersonTwo]);
        $response->assertStatus(200);

    }

    public function testStoreTransactionP2B()
    {
        [$idPersonOne, $shopkeeperId] = $this->startedTransactionP2B();

        $response = $this->postJson(route('transfer.create'), ['value' => 999, 'payer' => $idPersonOne, 'payee' => $shopkeeperId]);
        $response->assertStatus(200);

    }

    public function testInvalidateTypeTransactionShopkeeperToPerson()
    {
        $this->expectException(NoAllowedShopKeeperRuleException::class);
        [$idPersonOne, $shopkeeperId] = $this->startedTransactionP2B();

        $response = $this->postJson(route('transfer.create'), ['value' => 999, 'payer' => $shopkeeperId, 'payee' => $idPersonOne]);
        $response->assertStatus(422);

    }

    public function testInvalidateTypeTransactionShopkeeperToOther()
    {

        $shopkeeper = Uuid::uuid4()->toString();
        $shopkeeperTwo = Uuid::uuid4()->toString();

        $this->factoryShopkeeper($shopkeeper);
        $this->factoryShopkeeper($shopkeeperTwo);

        if (env('QUEUE_CONNECTION') === "sync") {
            $this->expectException(NoAllowedShopKeeperRuleException::class);
        }
        $response = $this->postJson(route('transfer.create'), ['value' => 999, 'payer' => $shopkeeper, 'payee' => $shopkeeperTwo]);

        if (env('QUEUE_CONNECTION') === "sync") {
            $response->assertStatus(422);
        }

        $response->assertStatus(200);

    }


    public function testValidationBalanceTransaction()
    {
        $valueInTransaction = 120;
        $startedBalance = 1000;

        [$idPersonOne, $idPersonTwo] = $this->startedTransactionP2P();

        $response = $this->postJson(route('transfer.create'), ['value' => $valueInTransaction, 'payer' => $idPersonOne, 'payee' => $idPersonTwo]);
        $response->assertStatus(200);

        if (env('QUEUE_CONNECTION') === "sync") {
            $bankAccountPayer = BankAccountModel::query()->where('client_id', '=', $idPersonOne)->take(1)->first();
            $bankAccountPayee = BankAccountModel::query()->where('client_id', '=', $idPersonTwo)->take(1)->first();

            $this->assertEquals($bankAccountPayer->balance, $startedBalance - $valueInTransaction);
            $this->assertEquals($bankAccountPayee->balance, $startedBalance + $valueInTransaction);
        }

    }


    public function testStoreStatementTransaction()
    {
        $valueInTransaction = rand(100, 500);
        [$idPersonOne, $idPersonTwo] = $this->startedTransactionP2P();

        $response = $this->postJson(route('transfer.create'), ['value' => $valueInTransaction, 'payer' => $idPersonOne, 'payee' => $idPersonTwo]);
        $response->assertStatus(200);

        if (env('QUEUE_CONNECTION') === "sync") {
            $bankAccountPayer = BankAccountModel::query()->where('client_id', '=', $idPersonOne)
                ->take(1)
                ->first();

            $bankAccountPayee = BankAccountModel::query()->where('client_id', '=', $idPersonTwo)
                ->take(1)
                ->first();


            $statementPayer = TransactionPayer::query()
                ->where('bank_account_id', '=', $bankAccountPayer->id())
                ->where('client_done_id', '=', $idPersonOne)
                ->where('created_at', '>', \Carbon\Carbon::now()->subMinutes(1))
                ->take(1)
                ->first();

            $this->assertIsObject($statementPayer);
            $this->assertEquals($statementPayer->value, $valueInTransaction);

            $statementPayee = TransactionPayee::query()
                ->where('bank_account_id', '=', $bankAccountPayee->id)
                ->where('client_done_id', '=', $idPersonTwo)
                ->where('created_at', '>', \Carbon\Carbon::now()->subMinutes(1))
                ->take(1)
                ->first();
            $this->assertIsObject($statementPayer);
            $this->assertEquals($statementPayee->value, $valueInTransaction);

        }
    }

    /**
     * @
     */
    public function testControllerException(): void
    {
        $request = $this->getMockBuilder(TransactionRequest::class)
                ->getMock();

        $service = $this->getMockBuilder(TransactionServiceAsyncInterface::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['store'])
            ->disableAutoReturnValueGeneration()
            ->getMock();

        $controller = new TransactionsController($service);
        $request = $controller->create($request);
        $this->assertEquals(422 ,$request->status());

    }

    protected function assertInvalidationFields(
        TestResponse $response,
        array $fields,
        string $rule,
        array $ruleParams = []
    )
    {
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors($fields);

        foreach ($fields as $field) {
            $fieldName = str_replace('_', ' ', $field);
            $response->assertJsonFragment([
                Lang::get("validation.{$rule}", ['attribute' => $fieldName] + $ruleParams),
            ]);
        }
    }

}

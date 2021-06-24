<?php

namespace Tests\Feature\Http\Controllers\Api\Transactions;

use App\ExternalAuthorization\ExternalAuthorization;
use App\Common\VerifyAuthorization\Exceptions\NoGranted;
use Tests\Stubs\ExternalAuthorization\ExternalValidatorErrorStub;
use Tests\Stubs\ExternalAuthorization\ExternalValidatorOfflineStub;

class TransactionsErrorControllersTest extends BaseTransactions
{

    public function testServiceGrantNoAuthorizedTransaction()
    {
        /**
         * Force stub error
         */
        $this->instance(ExternalAuthorization::class, new ExternalValidatorErrorStub());

        $this->expectException(NoGranted::class);
        [$idPersonOne, $idPersonTwo] = $this->startedTransactionP2P();

        $response = $this->postJson(route('transfer.create'), ['value' => 999, 'payer' => $idPersonOne, 'payee' => $idPersonTwo]);
        $response->assertStatus(422);

    }

    public function testServiceGrantOffline()
    {
        /**
         * Force stub error guzzle
         */
        $this->instance(ExternalAuthorization::class, new ExternalValidatorOfflineStub());
        [$idPersonOne, $idPersonTwo] = $this->startedTransactionP2P();

        $response = $this->postJson(route('transfer.create'), ['value' => 999, 'payer' => $idPersonOne, 'payee' => $idPersonTwo]);
        $response->assertStatus(200);

    }


}

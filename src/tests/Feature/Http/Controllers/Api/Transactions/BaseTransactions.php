<?php

namespace Tests\Feature\Http\Controllers\Api\Transactions;

use App\Models\CRM\Client\ClientModel;
use App\Models\CRM\Client\PersonModel;
use App\Models\CRM\Client\ShopkeeperModel;
use App\Models\Financial\BankAccount\BankAccountModel;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\Lang;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

abstract class BaseTransactions extends TestCase
{

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

    protected function startedTransactionP2P(): array
    {
        $idPersonOne = Uuid::uuid4()->toString();
        $idPersonTwo = Uuid::uuid4()->toString();

        $this->factoryPerson($idPersonOne);
        $this->factoryPerson($idPersonTwo);
        return [$idPersonOne, $idPersonTwo];
    }

    protected function startedTransactionP2B(): array
    {
        $idPersonOne = Uuid::uuid4()->toString();
        $shopTwo = Uuid::uuid4()->toString();

        $this->factoryPerson($idPersonOne);
        $this->factoryShopkeeper($shopTwo);
        return [$idPersonOne, $shopTwo];
    }


    public function factoryPerson(string $id, float $value = 1000)
    {
        $personOne = factory(PersonModel::class)->create();
        $clientOne = factory(ClientModel::class)->create(['id' => $id, 'document_type' => PersonModel::class, 'document_id' => $personOne->id]);
        factory(BankAccountModel::class)
            ->create(['client_id' => $id, 'balance' => $value]);
        return $clientOne;
    }

    public function factoryShopkeeper(string $id, float $value = 1000)
    {
        $personOne = factory(ShopkeeperModel::class)->create();
        $clientOne = factory(ClientModel::class)->create(['id' => $id, 'document_type' => ShopkeeperModel::class, 'document_id' => $personOne->id]);
        factory(BankAccountModel::class)
            ->create(['client_id' => $id, 'balance' => $value]);
        return $clientOne;
    }

}

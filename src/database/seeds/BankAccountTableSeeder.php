<?php

use Illuminate\Database\Seeder;

class BankAccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $clients = \App\Models\CRM\Client\ClientModel::all();

        foreach ($clients as $client) {
            factory(\App\Models\Financial\BankAccount\BankAccountModel::class)
                ->create(['client_id' => $client->id]);
        }

    }
}

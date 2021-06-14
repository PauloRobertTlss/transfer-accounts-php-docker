<?php

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\CRM\Client\PersonModel::class, 10)->create();
        factory(\App\Models\CRM\Client\ShopkeeperModel::class, 10)->create();

        $persons = \App\Models\CRM\Client\PersonModel::all();

        foreach ($persons as $person) {
            $client = factory(\App\Models\CRM\Client\ClientModel::class)
                ->create(['document_type' => \App\Models\CRM\Client\PersonModel::class,'document_id' => $person->id]);
        }

        $shopkeepers = \App\Models\CRM\Client\ShopkeeperModel::all();
        foreach ($shopkeepers as $shopkeeper) {
            $client = factory(\App\Models\CRM\Client\ClientModel::class)
                ->create(['document_type' => \App\Models\CRM\Client\ShopkeeperModel::class,'document_id' => $shopkeeper->id]);
        }

    }
}

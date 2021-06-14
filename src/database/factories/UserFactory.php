<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\CRM\Client\ClientModel::class, function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'name' => $faker->name
    ];
});

$factory->define(App\Models\CRM\Client\PersonModel::class, function (Faker $faker) {
    return [
        'document' => rand(100, 999) . '.' . rand(100, 999) . '.' . rand(100, 999) . '-' . rand(10, 99)
    ];
});

$factory->define(App\Models\CRM\Client\ShopkeeperModel::class, function (Faker $faker) {
    return [
        'document' => $faker->creditCardNumber
    ];
});

$factory->define(App\Models\Financial\BankAccount\BankAccountModel::class, function (Faker $faker) {

    return [
        'agency' => rand(100, 8999) . '-' . rand(1, 9),
        'account' => rand(500, 85258) . '-' . rand(1, 99),
        'balance' => $faker->randomFloat(1,100,1000 )
    ];
});

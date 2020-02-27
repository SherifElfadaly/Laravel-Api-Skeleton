<?php

$factory->define(App\Modules\OauthClients\OauthClient::class, function (Faker\Generator $faker) {
    return [
        'user_id'                => $faker->randomDigit(),
        'name'                   => $faker->name(),
        'secret'                 => \Illuminate\Support\Str::random(40),
        'redirect'               => $faker->url(),
        'personal_access_client' => 0,
        'password_client'        => 0,
        'revoked'                => $faker->boolean(),
        'created_at'             => $faker->dateTimeBetween('-1 years', 'now'),
        'updated_at'             => $faker->dateTimeBetween('-1 years', 'now')
    ];
});

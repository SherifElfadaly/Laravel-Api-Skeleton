<?php

$factory->define(App\Modules\V1\Acl\OauthClient::class, function (Faker\Generator $faker) {
    return [
    	'user_id'                => $faker->randomDigit(),
		'name'                   => $faker->name(),
		'secret'                 => str_random(40),
		'redirect'               => $faker->url(),
		'personal_access_client' => $faker->boolean(),
		'password_client'        => $faker->boolean(),
		'revoked'                => $faker->boolean(),
		'created_at'             => $faker->dateTimeBetween('-1 years', 'now'),
		'updated_at'             => $faker->dateTimeBetween('-1 years', 'now')
    ];
});

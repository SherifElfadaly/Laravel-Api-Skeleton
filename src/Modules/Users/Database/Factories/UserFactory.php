<?php

$factory->define(App\Modules\Users\AclUser::class, function (Faker\Generator $faker) {
    return [
        'profile_picture' => 'http://lorempixel.com/400/200/',
        'name'            => $faker->name(),
        'email'           => $faker->safeEmail(),
        'password'        => 123456,
        'created_at'      => $faker->dateTimeBetween('-1 years', 'now'),
        'updated_at'      => $faker->dateTimeBetween('-1 years', 'now')
    ];
});

<?php

$factory->define(App\Modules\Roles\Role::class, function (Faker\Generator $faker) {
    return [
        'name'       => $faker->unique->word(),
        'created_at' => $faker->dateTimeBetween('-1 years', 'now'),
        'updated_at' => $faker->dateTimeBetween('-1 years', 'now')
    ];
});

<?php

$factory->define(App\Modules\DummyModule\DummyModel::class, function (Faker\Generator $faker) {
    return [
        // Add factory attributes
        'created_at' => $faker->dateTimeBetween('-1 years', 'now'),
        'updated_at' => $faker->dateTimeBetween('-1 years', 'now')
    ];
});

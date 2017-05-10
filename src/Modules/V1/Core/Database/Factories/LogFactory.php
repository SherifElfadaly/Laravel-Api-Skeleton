<?php

$factory->define(App\Modules\V1\Core\Log::class, function (Faker\Generator $faker) {
    return [
		'id'         => $faker->unique()->randomDigitNotNull(),
		'action'     => $faker->randomElement(['create', 'delete', 'update']),
		'item_name ' => $faker->randomElement(['User', 'Settings', 'Group']),
		'item_id'    => $faker->unique()->randomDigitNotNull(),
		'user_id'    => $faker->unique()->randomDigitNotNull(),
		'created_at' => $faker->dateTimeBetween('-1 years', 'now'),
		'updated_at' => $faker->dateTimeBetween('-1 years', 'now')
    ];
});
<?php

$factory->define(App\Modules\V1\Notifications\Notification::class, function (Faker\Generator $faker) {
    return [
		'key'         => $faker->randomElement(['low_stock', 'order_added', 'new_request']),
		'item_name '  => $faker->randomElement(['User', 'Settings', 'Group']),
		'item_id'     => $faker->randomDigitNotNull(),
		'notified'    => $faker->numberBetween(0, 1),
		'data'        => [],
		'created_at'  => $faker->dateTimeBetween('-1 years', 'now'),
		'updated_at'  => $faker->dateTimeBetween('-1 years', 'now')
    ];
});
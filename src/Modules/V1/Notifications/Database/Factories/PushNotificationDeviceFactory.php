<?php

$factory->define(App\Modules\V1\Notifications\PushNotificationDevice::class, function (Faker\Generator $faker) {
    return [
		'device_token' => $faker->sha1(),
		'device_type ' => $faker->randomElement(['android', 'ios']),
		'user_id'      => $faker->randomDigitNotNull(),
		'active'       => $faker->numberBetween(0, 1),
		'created_at'   => $faker->dateTimeBetween('-1 years', 'now'),
		'updated_at'   => $faker->dateTimeBetween('-1 years', 'now')
    ];
});
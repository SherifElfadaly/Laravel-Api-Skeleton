<?php

$factory->define(App\Modules\PushNotificationDevices\PushNotificationDevice::class, function (Faker\Generator $faker) {
    return [
        'device_token' => $faker->sha1(),
        'user_id'      => $faker->randomDigitNotNull(),
        'created_at'   => $faker->dateTimeBetween('-1 years', 'now'),
        'updated_at'   => $faker->dateTimeBetween('-1 years', 'now')
    ];
});

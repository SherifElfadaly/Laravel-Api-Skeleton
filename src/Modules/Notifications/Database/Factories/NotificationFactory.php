<?php

$factory->define(App\Modules\Notifications\Notification::class, function (Faker\Generator $faker) {
    return [
        'type'            => '',
        'notifiable_type' => '',
        'notifiable_id'   => '',
        'data'            => '',
        'read_at'         => null,
        'created_at'      => $faker->dateTimeBetween('-1 years', 'now'),
        'updated_at'      => $faker->dateTimeBetween('-1 years', 'now')
    ];
});

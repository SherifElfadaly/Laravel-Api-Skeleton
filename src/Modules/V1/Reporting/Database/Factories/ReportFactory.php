<?php

$factory->define(App\Modules\V1\Reporting\Report::class, function (Faker\Generator $faker) {
    return [
		'id'          => $faker->randomDigitNotNull(),
		'report_name' => $faker->randomElement(['Users Count', 'Low Stock Products', 'Active Users']),
		'view_name'   => $faker->word(),
		'created_at'  => $faker->dateTimeBetween('-1 years', 'now'),
		'updated_at'  => $faker->dateTimeBetween('-1 years', 'now')
    ];
});
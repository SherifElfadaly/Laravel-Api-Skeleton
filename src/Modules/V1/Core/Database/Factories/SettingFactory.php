<?php

$factory->define(App\Modules\V1\Core\Settings::class, function (Faker\Generator $faker) {
    return [
		'id'         => $faker->randomDigitNotNull(),
		'name'       => $faker->randomElement(['Company Name', 'Title', 'Header Image']),
		'value'      => $faker->word(),
		'key'        => $faker->word(),
		'created_at' => $faker->dateTimeBetween('-1 years', 'now'),
		'updated_at' => $faker->dateTimeBetween('-1 years', 'now')
    ];
});
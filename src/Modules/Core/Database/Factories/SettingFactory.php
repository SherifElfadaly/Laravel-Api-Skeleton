<?php

$factory->define(App\Modules\Core\Settings::class, function (Faker\Generator $faker) {
    return [
		'name'       => $faker->randomElement(['Company Name', 'Title', 'Header Image']),
		'value'      => $faker->word(),
		'key'        => $faker->word(),
		'created_at' => $faker->dateTimeBetween('-1 years', 'now'),
		'updated_at' => $faker->dateTimeBetween('-1 years', 'now')
    ];
});

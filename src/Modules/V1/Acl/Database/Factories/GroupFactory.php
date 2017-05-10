<?php

$factory->define(App\Modules\V1\Acl\AclGroup::class, function (Faker\Generator $faker) {
    return [
		'id'         => $faker->unique()->randomDigitNotNull(),
		'name'       => $faker->randomElement(['Admin', 'Editor', 'Publisher']),
		'created_at' => $faker->dateTimeBetween('-1 years', 'now'),
		'updated_at' => $faker->dateTimeBetween('-1 years', 'now')
    ];
});

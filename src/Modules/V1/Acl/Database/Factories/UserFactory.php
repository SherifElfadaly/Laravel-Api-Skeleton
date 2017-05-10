<?php

$factory->define(App\Modules\V1\Acl\AclUser::class, function (Faker\Generator $faker) {
    return [
		'id'         => $faker->randomDigitNotNull(),
		'name'       => $faker->name(),
		'email'      => $faker->safeEmail(),
		'password'   => bcrypt(str_random(10)),
		'created_at' => $faker->dateTimeBetween('-1 years', 'now'),
		'updated_at' => $faker->dateTimeBetween('-1 years', 'now')
    ];
});

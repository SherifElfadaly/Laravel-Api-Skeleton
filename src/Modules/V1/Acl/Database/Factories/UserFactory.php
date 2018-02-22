<?php

$factory->define(App\Modules\V1\Acl\AclUser::class, function (Faker\Generator $faker) {
    return [
		'name'       => $faker->name(),
		'email'      => $faker->safeEmail(),
		'password'   => bcrypt(123456),
		'created_at' => $faker->dateTimeBetween('-1 years', 'now'),
		'updated_at' => $faker->dateTimeBetween('-1 years', 'now')
    ];
});

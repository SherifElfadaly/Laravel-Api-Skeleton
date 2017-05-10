<?php

$factory->define(App\Modules\V1\Acl\AclPermission::class, function (Faker\Generator $faker) {
    return [
		'id'         => $faker->unique()->randomDigitNotNull(),
		'name'       => $faker->randomElement(['save', 'delete', 'find', 'paginate']),
		'model'      => $faker->randomElement(['users', 'groups', 'settings', 'notifications']),
		'created_at' => $faker->dateTimeBetween('-1 years', 'now'),
		'updated_at' => $faker->dateTimeBetween('-1 years', 'now')
    ];
});

<?php

$factory->define(App\Modules\Acl\AclPermission::class, function (Faker\Generator $faker) {
    return [
		'name'       => $faker->randomElement(['save', 'delete', 'find', 'paginate']),
		'model'      => $faker->randomElement(['users', 'groups', 'settings', 'notifications']),
		'created_at' => $faker->dateTimeBetween('-1 years', 'now'),
		'updated_at' => $faker->dateTimeBetween('-1 years', 'now')
    ];
});

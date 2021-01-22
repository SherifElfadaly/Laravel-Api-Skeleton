<?php

namespace App\Modules\Permissions\Database\Factories;

use App\Modules\Permissions\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Permission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'       => $this->faker->randomElement(['save', 'delete', 'find', 'paginate']),
            'model'      => $this->faker->randomElement(['users', 'roles', 'settings', 'notifications']),
            'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 years', 'now')
        ];
    }
}

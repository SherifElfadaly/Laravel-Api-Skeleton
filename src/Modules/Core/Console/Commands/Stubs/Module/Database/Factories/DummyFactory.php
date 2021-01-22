<?php

namespace App\Modules\DummyModule\Database\Factories;

use App\Modules\DummyModule\DummyModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class DummyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DummyModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // Add factory attributes
            'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 years', 'now')
        ];
    }
}

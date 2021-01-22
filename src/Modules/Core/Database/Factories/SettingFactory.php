<?php

namespace App\Modules\Core\Database\Factories;

use App\Modules\Core\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Setting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'       => $this->faker->randomElement(['Company Name', 'Title', 'Header Image']),
            'value'      => $this->faker->word(),
            'key'        => $this->faker->word(),
            'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 years', 'now')
        ];
    }
}

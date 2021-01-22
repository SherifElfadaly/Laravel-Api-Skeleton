<?php

namespace App\Modules\Reporting\Database\Factories;

use App\Modules\Reporting\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'report_name' => $this->faker->randomElement(['Users Count', 'Low Stock Products', 'Active Users']),
            'view_name'   => $this->faker->word(),
            'created_at'  => $this->faker->dateTimeBetween('-1 years', 'now'),
            'updated_at'  => $this->faker->dateTimeBetween('-1 years', 'now')
        ];
    }
}

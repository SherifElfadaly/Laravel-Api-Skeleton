<?php

namespace App\Modules\Notifications\Database\Factories;

use App\Modules\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type'            => '',
            'notifiable_type' => '',
            'notifiable_id'   => '',
            'data'            => '',
            'read_at'         => null,
            'created_at'      => $this->faker->dateTimeBetween('-1 years', 'now'),
            'updated_at'      => $this->faker->dateTimeBetween('-1 years', 'now')
        ];
    }
}

<?php

namespace App\Modules\PushNotificationDevices\Database\Factories;

use App\Modules\PushNotificationDevices\PushNotificationDevice;
use Illuminate\Database\Eloquent\Factories\Factory;

class PushNotificationDeviceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PushNotificationDevice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'device_token' => $this->faker->sha1(),
            'user_id'      => $this->faker->randomDigitNotNull(),
            'created_at'   => $this->faker->dateTimeBetween('-1 years', 'now'),
            'updated_at'   => $this->faker->dateTimeBetween('-1 years', 'now')
        ];
    }
}

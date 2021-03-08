<?php

namespace App\Modules\Users\Database\Factories;

use App\Modules\Users\AclUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AclUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'profile_picture' => 'https://picsum.photos/200/300',
            'name'            => $this->faker->name(),
            'email'           => $this->faker->safeEmail(),
            'password'        => 123456,
            'created_at'      => $this->faker->dateTimeBetween('-1 years', 'now'),
            'updated_at'      => $this->faker->dateTimeBetween('-1 years', 'now')
        ];
    }
}

<?php

namespace App\Modules\OauthClients\Database\Factories;

use App\Modules\OauthClients\OauthClient;
use Illuminate\Database\Eloquent\Factories\Factory;
use \Illuminate\Support\Str;

class OauthClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OauthClient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'                => $this->faker->randomDigit(),
            'name'                   => $this->faker->name(),
            'secret'                 => Str::random(40),
            'redirect'               => $this->faker->url(),
            'personal_access_client' => 0,
            'password_client'        => 0,
            'revoked'                => $this->faker->boolean(),
            'created_at'             => $this->faker->dateTimeBetween('-1 years', 'now'),
            'updated_at'             => $this->faker->dateTimeBetween('-1 years', 'now')
        ];
    }
}

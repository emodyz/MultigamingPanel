<?php

namespace Database\Factories;

use App\Models\ServerStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServerStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServerStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'online' => $this->faker->boolean,
            'players_max' => $this->faker->randomNumber(3),
            'players_online' => $this->faker->randomNumber(3)
        ];
    }
}

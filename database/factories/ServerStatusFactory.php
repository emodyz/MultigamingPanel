<?php

namespace Database\Factories;

use App\Models\ServerStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

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
            'players_max' => 230,
            'players_online' => $this->faker->numberBetween(10, 230),
            'created_at' => $random = Carbon::today()->subDays(rand(0, 30))->subMinutes(rand(0, 1439)),
        ];
    }
}

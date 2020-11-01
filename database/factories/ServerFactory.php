<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Server;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Server::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'ip' => $this->faker->ipv4,
            'port' => $this->faker->randomNumber(4),
            'game_id' => fn() => Game::factory()->create()->id
        ];
    }
}

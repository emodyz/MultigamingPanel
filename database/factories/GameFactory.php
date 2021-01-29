<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'identifier' => $this->faker->uuid,
            'appid' => $this->faker->randomNumber(),
        ];
    }

    /**
     * @return GameFactory
     */
    public function asArma3(): GameFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'ArmA 3',
                'identifier' => 'arma3',
                'appid' => 107410,
                'logo_path' => 'games/arma3.png'
            ];
        });
    }
}

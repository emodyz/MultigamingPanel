<?php

namespace Database\Factories;

use App\Models\Modpack;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModpackFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Modpack::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => "@{$this->faker->firstName}",
            'disk' => 'modpacks',
            'path' => $this->faker->firstName
        ];
    }
}

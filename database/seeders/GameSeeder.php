<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Game::factory()->create([
            'name' => 'Arma3',
            'identifier' => 'arma3',
            'appid' => 107410,
            'logo_path' => 'games/arma3.png'
        ]);
    }
}

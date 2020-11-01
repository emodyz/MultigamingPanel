<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Server;
use Illuminate\Database\Seeder;

class ServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $game = Game::whereIdentifier('arma3')->first();

        Server::factory()->create([
            'name' => 'Projet Renaissance',
            'ip' => '54.36.127.224',
            'port' => 2302,
            'game_id' => $game->id
        ]);

        Server::factory()->create([
            'name' => 'LiveYourLife',
            'ip' => 'altis.lyl.gg',
            'port' => 2302,
            'game_id' => $game->id
        ]);

    }
}

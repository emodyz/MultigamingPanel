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
        $arma3 = Game::whereIdentifier('arma3')->first();
        $minecraft = Game::whereIdentifier('minecraft')->first();

        Server::factory()->create([
            'name' => 'LiveYourLife',
            'ip' => 'altis.lyl.gg',
            'port' => 2302,
            'game_id' => $arma3->id
        ]);

        Server::factory()->create([
            'name' => 'Projet Renaissance',
            'ip' => '54.36.127.224',
            'port' => 2302,
            'game_id' => $arma3->id
        ]);

        Server::factory()->create([
          'name' => 'MineSuperior',
          'ip' => 'server.mcs.gg',
          'port' => 25565,
          'game_id' => $minecraft->id
        ]);
    }
}

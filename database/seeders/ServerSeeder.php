<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Server;
use App\Models\ServerStatus;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

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

        $server = Server::factory()->create([
            'name' => 'LIVEYOURLIFE - Altis',
            'ip' => 'altis.lyl.gg',
            'port' => 2302,
            'game_id' => $arma3->id
        ]);

        ServerStatus::factory()->count(rand(5000, 10000))->create([
            'online' => true,
            'server_id' => $server->id,
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

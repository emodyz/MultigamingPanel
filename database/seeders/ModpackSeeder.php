<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Modpack;
use App\Models\Server;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ModpackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $directories = Storage::disk('modpacks')->allDirectories();
        foreach ($directories as $directory) {
            Storage::disk('modpacks')->deleteDirectory($directory);
        }

        $arma3 = Game::whereIdentifier('arma3')->first();

        $modpack1 = Modpack::factory()->create([
          'game_id' => $arma3->id
        ]);
        $modpack2 = Modpack::factory()->create([
          'game_id' => $arma3->id
        ]);
        $modpack3 = Modpack::factory()->create([
          'game_id' => $arma3->id
        ]);
        $servers = Server::whereGameId($arma3->id)->get();

        foreach ($servers as $server) {
            $server->modpacks()->attach($modpack1->id);
        }
        $servers->first()->modpacks()->attach([$modpack2->id, $modpack3->id]);
    }
}

<?php

namespace Database\Seeders;

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

        $modpack1 = Modpack::factory()->create();
        $modpack2 = Modpack::factory()->create();
        $servers = Server::all();

        foreach ($servers as $server) {
            $server->modpacks()->attach($modpack1->id);
        }
        $servers->first()->modpacks()->attach($modpack2->id);
    }
}

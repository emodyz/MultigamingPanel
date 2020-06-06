<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(\App\User::class)->create([
            'name' => 'John Doe',
            'email' => 'test@emodyz.eu',
            'password' => Hash::make('password')
        ]);

        $gameArma3 = factory(\App\Game::class)->create([
            'name' => 'Arma3',
            'identifier' => 'arma3',
            'appid' => 107410,
            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/fa/ArmA_3_Logo_(Black).png'
        ]);

        /**
         * @var $modpack1 \App\Modpack
         */
        $modpack1 = factory(\App\Modpack::class)->create();

        /**
         * @var $flashServer \App\Server
         */
        $flashServer = factory(\App\Server::class)->create([
            'name' => 'Flash',
            'ip' => '78.129.89.37',
            'port' => 2302,
            'game_id' => $gameArma3->id
        ]);
        factory(\App\Server::class)->create([
            'name' => 'HARM',
            'ip' => '77.250.59.106',
            'port' => 2302,
            'game_id' => $gameArma3->id
        ]);
        factory(\App\Server::class)->create([
            'name' => 'Server TEST',
            'ip' => '151.80.230.188',
            'port' => 2502,
            'game_id' => $gameArma3->id
        ]);

        $flashServer->modpacks()->attach($modpack1->id);
        Artisan::call('modpacks:clean', [], $this->command->getOutput());
    }
}

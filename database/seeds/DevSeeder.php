<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->create([
            'name' => 'John Doe',
            'email' => 'test@emodyz.eu',
            'password' => Hash::make('password')
        ]);

        factory(\App\Game::class)->create([
            'name' => 'Arma3',
            'identifier' => 'arma3',
            'appid' => 107410,
            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/fa/ArmA_3_Logo_(Black).png'
        ]);

        factory(\App\Server::class)->create([
            'name' => 'Flash',
            'ip' => '78.129.89.37',
            'port' => 2302
        ]);
        factory(\App\Server::class)->create([
            'name' => 'HARM',
            'ip' => '77.250.59.106',
            'port' => 2302
        ]);
        factory(\App\Server::class)->create([
            'name' => 'Server TEST',
            'ip' => '151.80.230.188',
            'port' => 2502
        ]);
        factory(\App\Server::class, 4)->create();
    }
}

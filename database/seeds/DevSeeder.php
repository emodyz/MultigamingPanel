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
    }
}

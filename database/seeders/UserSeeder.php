<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        tap(User::factory()->create([
            'email' => 'root@root.com',
            'role' => 'owner',
            'email_verified_at' => now()
        ]), function (User $user) {
            $user->ownedTeams()->save(Team::forceCreate([
                'user_id' => $user->id,
                'name' => explode(' ', $user->name, 2)[0]."'s Team",
                'personal_team' => true,
            ]));
        });

        User::factory()->count(rand(30, 1000))->create();
    }
}

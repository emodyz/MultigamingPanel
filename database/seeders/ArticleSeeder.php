<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Server;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'root@root.com')->first();
        $server = Server::first();

        Article::factory()->withCover()->withContent()->count(rand(3, 10))->create([
            'user_id' => $user->id
        ]);

        $articles = Article::factory()->withCover()->withContent()->count(10)->create([
            'user_id' => $user->id
        ]);

        foreach ($articles as $a) {
            $a->servers()->attach($server);
        }
    }
}

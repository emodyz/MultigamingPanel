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
        $faker = Factory::create();

        $user = User::where('email', 'root@root.com')->first();
        $server = Server::first();

        $fakeImage = Http::get($faker->imageUrl(640, 480, 'cats', true, 'Placeholder'));

        $imagePath = 'cover-images/articles/placeholder.jpg';

        Storage::disk('public')->put($imagePath, $fakeImage->body());

        tap(Article::factory()->create([
            'user_id' => $user->id,
            'cover_image_path' => $imagePath
        ]),function (Article $article) use ($server) {
            $article->servers()->attach($server);
        });
    }
}

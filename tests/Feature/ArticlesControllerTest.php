<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Server;
use App\Models\ServerStatus;
use Faker\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class ArticlesControllerTest extends TestCase
{
    /**
     * @test
     */
    public function an_unauthorized_user_can_not_manage_articles()
    {
        $this->initUser();

        $article = Article::factory()->create([
            'user_id' => auth()->user()->id,
            'cover_image_path' => ''
        ]);

        $this->get(route('articles.index'))
            ->assertForbidden();

        $this->get(route('articles.create'))
            ->assertForbidden();

        $this->post(route('articles.store'))
            ->assertForbidden();

        $this->get(route('articles.edit', $article))
            ->assertForbidden();

        $this->put(route('articles.update', $article))
            ->assertForbidden();

        $this->put(route('articles.destroy', $article))
            ->assertForbidden();
    }

    /**
     * @test
     */
    public function an_authorized_user_can_write_an_article()
    {
        $faker = Factory::create();

        $this->initUser('owner');

        $server = Server::factory()->create();

        $title = $faker->sentence(5 );

        $this->post(route('articles.store'), [
            'title' => $title,
            'subTitle' => $faker->sentence(15 ),
            'servers' => [$server->id],
            'coverImage' => UploadedFile::fake()->image('cover.jpg'),
            'content' => $faker->text,
            'status' => 'published',
        ])->assertStatus(302);

        $this->assertDatabaseHas('articles', [
            'slug' => Str::slug($title)
        ]);
    }

    /**
     * @test
     */
    public function _can_edit_an_article()
    {
        $faker = Factory::create();

        $this->initUser('owner');

        $server = Server::factory()->create();

        $article = Article::factory()->create([
            'user_id' => auth()->user()->id,
            'status' => 'draft',
            'published_at' => null
        ]);

        $newTitle = $faker->sentence(5 );
        $newSubTitle = $faker->sentence(15 );
        $newContent = $faker->text;
        $newServer = [$server->id];
        $newStatus = 'published';

        $this->put(route('articles.update', $article), [
            'title' => $newTitle,
            'subTitle' => $newSubTitle,
            'servers' => $newServer,
            'coverImage' => UploadedFile::fake()->image('cover.jpg', 64,64),
            'content' => $newContent,
            'status' => $newStatus,
        ])->assertStatus(302);

        $this->assertDatabaseHas('articles', [
            'title' => $newTitle,
            'subTitle'=> $newSubTitle,
            'slug' => Str::slug($newTitle),
            'content' => $newContent,
            'status' => $newStatus,
        ]);

        $article = Article::where('id', $article->id)->first();

        $this->assertEquals($server->id, $article->servers->first()->id);
    }



    /**
     * @test
     */
    public function _can_delete_an_article() {
        $this->initUser('owner');

        $article = Article::factory()->create([
            'user_id' => auth()->user()->id,
            'cover_image_path' => ''
        ]);

        $this->delete(route('articles.destroy', $article));

        $this->assertSoftDeleted($article);
    }

}

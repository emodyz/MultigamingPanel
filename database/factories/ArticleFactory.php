<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $md = Http::get('https://jaspervdj.be/lorem-markdownum/markdown.txt');

        $title = $this->faker->sentence(5);

        $status = $this->faker->randomElement(['draft', 'published']);

        return [
            'title' => $title,
            'subTitle' => $this->faker->sentence(20),
            'slug' => Str::slug($title),
            'content' => $md->body(),
            'status' => $status,
            'published_at' => ($status === 'published') ? now() : null,
        ];
    }
}

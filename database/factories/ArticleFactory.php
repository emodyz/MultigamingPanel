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
        $title = $this->faker->sentence(5);
        $status = $this->faker->randomElement(['draft', 'published']);

        return [
            'title' => $title,
            'subTitle' => $this->faker->sentence(20),
            'slug' => Str::slug($title),
            'cover_image_path' => '',
            'content' => '',
            'status' => $status,
            'published_at' => ($status === 'published') ? now() : null,
        ];
    }

    /**
     * @return ArticleFactory
     */
    public function withCover(): ArticleFactory
    {
        return $this->state(function (array $attributes) {
            $fakeImage = Http::get('https://picsum.photos/640/480');
            $imagePath = 'cover-images/articles/placeholder-'. $this->faker->uuid .'.jpg';
            Storage::disk('public')->put($imagePath, $fakeImage->body());

            return [
                'cover_image_path' => $imagePath,
            ];
        });
    }

    /**
     * @return ArticleFactory
     */
    public function withContent(): ArticleFactory
    {
        return $this->state(function (array $attributes) {
            $md = Http::get('https://jaspervdj.be/lorem-markdownum/markdown.txt');

            return [
                'content' => $md->body(),
            ];
        });
    }
}

<?php

namespace App\Actions\Emodyz\Articles;

use App\Models\Article;
use App\Models\User;
use App\Rules\RoleExists;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CreateArticle
{
    /**
     * @param array $input
     * @return Article
     */
    public function storeNewArticle(array $input): Article
    {
        $article = new Article();

        $title = $input['title'];
        $servers = $input['servers'];

        $article->setAttribute('title', $title);
        $article->setAttribute('subTitle', $input['subTitle']);
        $article->setAttribute('slug', Str::slug($title));
        $article->setAttribute('content', $input['content']);

        $article->setAttribute('user_id', auth()->user()->id);

        $article->setInitialCoverImage($input['coverImage']);

        if ($input['status'] === 'published') {
            $article->setAttribute('status', 'published');
            $article->setAttribute('published_at', now());
        }

        $article->save();

        if ($servers) {
            foreach ($servers as $server) {
                $article->servers()->attach($server);
            }
        }

        return $article;
    }
}

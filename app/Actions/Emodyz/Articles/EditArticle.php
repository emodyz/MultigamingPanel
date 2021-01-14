<?php

namespace App\Actions\Emodyz\Articles;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Str;

class EditArticle
{
    /**
     * Validate and update the given user if the initiator has the appropriate authorizations.
     *
     * @param Article $article
     * @param array $input
     * @return void
     */
    public function editArticle(Article $article, array $input)
    {
        $newCoverImage = $input['coverImage'];

        if ($newCoverImage) {
            $article->updateCoverImage($newCoverImage);
        }

        $title = $input['title'];
        $servers = $input['servers'];
        $status = $input['status'];

        $article->setAttribute('title', $title);
        $article->setAttribute('subTitle', $input['subTitle']);
        $article->setAttribute('slug', Str::slug($title));
        $article->setAttribute('content', $input['content']);


        $article->setAttribute('status', $status);
        $article->setAttribute('published_at', $status ? now() : null);

        $article->save();

        $article->servers()->sync($servers);

    }
}

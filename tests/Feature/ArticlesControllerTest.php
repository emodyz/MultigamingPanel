<?php

namespace Tests\Feature;

use App\Models\Server;
use App\Models\ServerStatus;
use Tests\TestCase;

class ArticlesControllerTest extends TestCase
{
    /**
     * @test
     */
    public function an_unauthorized_user_can_not_manage_articles()
    {
        $this->initUser();

        $this->get(route('articles.index'))
            ->assertForbidden();
    }
}

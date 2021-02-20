<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Server;
use App\Models\ServerStatus;
use App\Models\User;
use Faker\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class StatsControllerTest extends TestCase
{
    /**
     * @test
     */
    public function an_unauthorized_user_can_not_view_stats()
    {
        $this->initUser();

        $this->get(route('api.dashboard.stats.users'))
            ->assertForbidden();

        $this->get(route('api.dashboard.stats.servers'))
            ->assertForbidden();
    }

    /**
     * @test
     */
    public function an_authorized_user_can_view_the_users_growth_graph()
    {
        $faker = Factory::create();

        $this->initUser('owner');


        User::factory()->count(5)->create([
            'created_at' => Carbon::today()->subDays(2),
        ]);

        User::factory()->count(10)->create([
            'created_at' => Carbon::today()->subDays(1),
        ]);

        User::factory()->count(7)->create([
            'created_at' => Carbon::today(),
        ]);

        $this->get(route('api.dashboard.stats.users'))
            ->assertOk()
            ->assertJson(['dailyDiff' => -30, 'isDailyDiffPositive' => false, 'graphData' => [1,5,10,7], 'total' => 23]);
    }

}

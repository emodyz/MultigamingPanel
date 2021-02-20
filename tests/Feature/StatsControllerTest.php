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
        $this->initUser('owner');


        User::factory()->count(5)->create([
            'created_at' => Carbon::today()->subDays(2),
        ]);

        User::factory()->count(10)->create([
            'created_at' => Carbon::today()->subDays(),
        ]);

        User::factory()->count(7)->create([
            'created_at' => Carbon::today(),
        ]);

        $this->get(route('api.dashboard.stats.users'))
            ->assertOk()
            ->assertJson(['dailyDiff' => -30, 'isDailyDiffPositive' => false, 'graphData' => [1,5,10,7], 'total' => 23]);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_view_the_servers_graph()
    {
        $faker = Factory::create();

        $serverName = $faker->domainName;

        $this->initUser('owner');

        $server = Server::factory()->create([
            'name' => $serverName,
        ]);

        ServerStatus::factory()->create([
            'online' => true,
            'server_id' => $server->id,
            'players_online' => 1,
            'created_at' => Carbon::today()->subDays(),
        ]);

        ServerStatus::factory()->create([
            'online' => true,
            'server_id' => $server->id,
            'players_online' => 20,
            'created_at' => Carbon::today()->subDays(2),
        ]);

        ServerStatus::factory()->create([
            'online' => true,
            'server_id' => $server->id,
            'players_online' => 30,
            'created_at' => Carbon::today(),
        ]);

        $this->get(route('api.dashboard.stats.servers'))
            ->assertOk()
            ->assertJson([['dailyDiff' => 2900, 'isDailyDiffPositive' => true, 'graphData' => [20,1,30], 'total' => 30, 'metaData' => ['serverName' => $serverName]]]);
    }

}

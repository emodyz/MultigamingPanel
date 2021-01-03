<?php

namespace Tests\Feature\Server;

use App\Jobs\ProcessServersStatuses;
use App\Models\Game;
use App\Models\Server;
use App\Models\ServerStatus;
use Tests\TestCase;

class GameServerStatusJobTest extends TestCase
{
    /**
     * @test
     */
    public function assert_that_process_servers_statuses_job_fetch_all_games_servers()
    {
        $game = Game::factory()->createOne([
            'name' => 'Arma3',
            'identifier' => 'arma3',
            'appid' => 107410,
            'logo_path' => 'games/arma3.png'
        ]);

        Server::factory(3)->create([
            'game_id' => $game->id
        ]);

        $this->assertCount(0, ServerStatus::all());
        ProcessServersStatuses::dispatch();
        $this->assertCount(3, ServerStatus::all());
    }

}

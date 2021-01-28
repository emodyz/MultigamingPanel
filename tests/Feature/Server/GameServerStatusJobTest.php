<?php

namespace Tests\Feature\Server;

use App\Jobs\ProcessServersStatuses;
use App\Models\Game;
use App\Models\Server;
use App\Models\ServerStatus;
use GameQ\GameQ;
use Mockery\MockInterface;
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

  /**
   * @test
   */
  public function assert_servers_status_was_correct()
  {
    $game = Game::factory()->createOne([
      'name' => 'Arma3',
      'identifier' => 'arma3',
      'appid' => 107410,
      'logo_path' => 'games/arma3.png'
    ]);

    $servers = Server::factory(3)->create([
      'game_id' => $game->id
    ]);

    $mockedReturnObject = $servers->mapWithKeys(fn(Server $server) => [
      $server->host() => [
        'gq_online' => true,
        'gq_maxplayers' => rand(50, 130),
        'gq_numplayers' => rand(20, 100)
      ]
    ])->toArray();

    $this->partialMock(GameQ::class, function (MockInterface $mock) use ($mockedReturnObject) {
      $mock->shouldReceive('process')
        ->times(3)
        ->andReturn($mockedReturnObject);
    });

    $this->assertCount(0, ServerStatus::all());
      ProcessServersStatuses::dispatch();
    $this->assertCount(3, ServerStatus::all());

    foreach (Server::cursor() as $server) {
      $serverMockedResponse = $mockedReturnObject[$server->host()];

      $this->assertEquals($serverMockedResponse['gq_online'], $server->latest_status->online);
      $this->assertEquals($serverMockedResponse['gq_maxplayers'], $server->latest_status->players_max);
      $this->assertEquals($serverMockedResponse['gq_numplayers'], $server->latest_status->players_online);
    }
  }
}

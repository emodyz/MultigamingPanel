<?php

namespace App\Services\Games;

use App\Models\Server;
use App\Models\ServerStatus;
use GameQ\GameQ;

class GamesStatusService
{
  /**
   * @var GameQ
   */
  private GameQ $gameQ;

  /**
   * GamesStatusService constructor.
   * @param GameQ $gameQ
   */
  public function __construct(GameQ $gameQ)
  {
    $this->gameQ = $gameQ;
  }

  /**
   * @param Server $server
   * @throws \Exception
   */
  public function fetchServerStatus(Server $server)
  {
    $this->gameQ->clearServers();

    $this->gameQ->addServer([
      'type' => $server->game->identifier,
      'host' => $server->host()
    ]);

    $results = $this->gameQ->process()[$server->host()];

    ServerStatus::create([
      'server_id' => $server->id,
      'online' => $results['gq_online'] ?? false,
      'players_max' => $results['gq_maxplayers'] ?? 0,
      'players_online' => $results['gq_numplayers'] ?? 0
    ]);
  }
}

<?php

namespace App\Services\Games;

use App\Models\Server;
use App\Models\ServerStatus;
use GameQ\GameQ;

class GamesStatusService
{
    public static function fetchStatus(Server $server)
    {
        $gameQ = new GameQ();
        $gameQ->addServer([
            'type' => $server->game->identifier,
            'host' => $server->host()
        ]);

        $results = $gameQ->process()[$server->host()];

        ServerStatus::create([
            'server_id' => $server->id,
            'online' => $results['gq_online'] ?? false,
            'players_max' => $results['max_players'] ?? 0,
            'players_online' => $results['num_players'] ?? 0
        ]);
    }
}

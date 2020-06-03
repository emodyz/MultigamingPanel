<?php


if (!function_exists('fetch_server_status')) {
    function fetch_server_status(\App\Server $server): array
    {
        $gameQ = new \GameQ\GameQ();
        $host = "$server->ip:$server->port";
        $gameQ->addServer([
            'type' => $server->game->identifier,
            'host' => $host,
        ]);

        $results = $gameQ->process();
        switch ($server->game->identifier) {
            case 'arma3':
                return (new \App\Http\Resources\ServerStatus\Arma3StatusResource($results[$host]))->toArray(null);
                break;
            default:
                abort(501);
        }
    }

    function fetch_servers_status(\Illuminate\Support\Collection $servers): \Illuminate\Support\Collection
    {
        $gameQ = new \GameQ\GameQ();
        $servers->each(function ($server) use ($gameQ) {
            $gameQ->addServer([
                'type' => $server->game->identifier,
                'host' => "{$server->ip}:$server->port",
            ]);
        });

        $results = $gameQ->process();

        $serversResult = collect([]);
        $servers->each(function ($server) use ($results, $serversResult) {
            switch ($server->game->identifier) {
                case 'arma3':
                    $serversResult->push(
                        (new \App\Http\Resources\ServerStatus\Arma3StatusResource($results["{$server->ip}:$server->port"]))->toArray(null)
                    );
                    break;
                default:
                    abort(501);
            }
        });

        return $serversResult;
    }
}

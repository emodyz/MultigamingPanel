<?php

namespace App\Actions\Emodyz\Servers;

use App\Models\Server;

class CreateServer
{
    /**
     * @param array $input
     * @return Server
     */
    public function storeNewServer(array $input): Server
    {
        $server = new Server();

        $gameId = $input['game'];
        $modPacks = $input['modPacks'];

        $server->setAttribute('name', $input['name']);
        $server->setAttribute('ip', $input['ip']);
        $server->setAttribute('port', $input['port']);

        if (isset($input['logo'])) {
            $server->setInitialLogo($input['logo']);
        }

        $server->setAttribute('game_id', $gameId);

        $server->save();

        if (!empty($modPacks)) {
            $server->modpacks()->sync($modPacks);
        }

        return $server;
    }
}

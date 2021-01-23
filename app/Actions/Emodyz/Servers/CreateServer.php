<?php

namespace App\Actions\Emodyz\Servers;

use App\Models\Article;
use App\Models\Server;
use Illuminate\Support\Str;

class CreateServer
{
    /**
     * @param array $input
     * @return void
     */
    public function storeNewServer(array $input)
    {
        $server = new Server();

        $gameId = $input['game'];
        $modPackId = $input['modPack'];

        $server->setAttribute('name', $input['name']);
        $server->setAttribute('ip', $input['ip']);
        $server->setAttribute('port', $input['port']);

        if (isset($input['logo'])) {
            $server->setInitialLogo($input['logo']);
        }

        $server->setAttribute('game_id', $gameId);

        $server->save();

        $server->modpacks()->sync([$modPackId]);
    }
}

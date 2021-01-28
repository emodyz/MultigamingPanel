<?php

namespace App\Actions\Emodyz\Servers;

use App\Models\Server;

class EditServer
{
    /**
     * Validate and update the given user if the initiator has the appropriate authorizations.
     *
     * @param Server $server
     * @param array $input
     * @return void
     */
    public function editServer(Server $server, array $input)
    {
        $newLogo = $input['logo'];

        if (isset($newLogo)) {
            $server->updateLogo($newLogo);
        }
        $modPacks = $input['modPacks'];

        $server->setAttribute('name', $input['name']);
        $server->setAttribute('ip', $input['ip']);
        $server->setAttribute('port', $input['port']);

        $server->save();

        $server->modpacks()->sync($modPacks);
    }
}

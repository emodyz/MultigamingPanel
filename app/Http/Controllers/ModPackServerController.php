<?php

namespace App\Http\Controllers;

use App\Models\Modpack;
use App\Models\Server;

class ModPackServerController extends Controller
{
    /**
     * @param Modpack $modpack
     * @param Server $server
     * @return \Illuminate\Http\Response
     */
    public function attach(Modpack $modpack, Server $server)
    {
        if ($modpack->servers->contains($server)) {
            abort(422, "Already attached");
        }

        $modpack->servers()->attach($server);
        return response()->noContent();
    }

    /**
     * @param Modpack $modpack
     * @param Server $server
     * @return \Illuminate\Http\Response
     */
    public function detach(Modpack $modpack, Server $server)
    {
        if (!$modpack->servers->contains($server)) {
            abort(422, "This server was not attached to this modpack");
        }

        $modpack->servers()->detach($server);
        return response()->noContent();
    }
}

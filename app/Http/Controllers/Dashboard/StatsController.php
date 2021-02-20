<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Server;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class StatsController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:dashboard-stats');
    }

    public function users(): JsonResponse
    {
        return response()->json(new UsersStats());
    }

    public function servers(): JsonResponse
    {
        $servers = Cache::remember('servers-online', 60, function () {
            return Server::online();
        });

        $serversStats = collect();
        foreach ($servers as $server)
        {
            $serversStats->push(new ServerStats($server));
        }
        return response()->json($serversStats);
    }
}

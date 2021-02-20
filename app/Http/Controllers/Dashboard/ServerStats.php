<?php


namespace App\Http\Controllers\Dashboard;


use App\Models\Server;
use App\Models\ServerStatus;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Mattiasgeniar\Percentage\Percentage;

class ServerStats extends Contracts\DashboardStats
{
    protected mixed $serverId;
    protected Server $server;
    private int $cacheTtl = 600;

    public function __construct(Server $server)
    {
        $this->serverId = $server->getKey();
        $this->server = $server;

        parent::__construct();
    }

    public function setDailyDiff(): void
    {
        $playersToday = Cache::remember('playersToday'. $this->serverId, $this->cacheTtl, function () {
            $q = ServerStatus::select('players_online', 'created_at')
                ->where('online', true)
                ->where('server_id', $this->serverId)
                ->where('online', true)
                ->whereDate('created_at', Carbon::today())
                ->get()
                ->map(function ($el) {
                    return $el->players_online;
                });
            if ($q->count() <= 0) {
                $q->push(0);
            }
            return $q;
        });

        $averagePlayersToday = $playersToday->average();

        $playersYesterday = Cache::remember('playersYesterday'. $this->serverId, $this->cacheTtl, function () {
            $q = ServerStatus::select('players_online', 'created_at')
                ->where('online', true)
                ->where('server_id', $this->serverId)
                ->where('online', true)
                ->whereDate('created_at', Carbon::yesterday())
                ->get()
                ->map(function ($el) {
                    return $el->players_online;
                });
            if ($q->count() <= 0) {
                $q->push(0);
            }
            return $q;
        });

        $averagePlayersYesterday = $playersYesterday->average();

        $this->dailyDiff = ($averagePlayersYesterday && $averagePlayersToday)
            ? round(Percentage::differenceBetween($averagePlayersYesterday, $averagePlayersToday), 2)
            : null;

        $this->isDailyDiffPositive = $this->dailyDiff > 0;
    }

    public function setGraphData(): void
    {
        $monthlyPlayersByDay = Cache::remember('monthlyPlayersByDay'. $this->serverId, $this->cacheTtl, function () {
            return ServerStatus::select('players_online', 'created_at')
                ->where('server_id', $this->serverId)->where('online', true)
                ->where('created_at', '>=', Carbon::today()->subMonth())
                ->orderBy('created_at')
                ->get()
                ->groupBy(function ($val) {
                    return Carbon::parse($val->created_at)->format('d');
                });
        });

        $averagePlayers = $monthlyPlayersByDay->map(function ($el) {
            $stats = $el->map(function ($stat) {
                return $stat->players_online;
            });

            return $stats->average();
        });

        if ($averagePlayers->values()->count() <= 1) {
            $averagePlayers->prepend(0);
        }

        $this->graphData = $averagePlayers->values();
    }

    public function setTotal(): void
    {
        $this->total = Cache::remember('total'. $this->serverId, $this->cacheTtl, function () {
            return $this->server->latest_status->players_online;
        });
    }

    public function setMetaData(): void {
        $this->metaData = ['serverName' => $this->server->name];
    }
}

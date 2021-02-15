<?php


namespace App\Http\Controllers\Dashboard;


use App\Models\Server;
use App\Models\ServerStatus;
use Illuminate\Support\Carbon;
use Mattiasgeniar\Percentage\Percentage;

class ServerStats extends Contracts\DashboardStats
{
    protected mixed $serverId;
    protected Server $server;

    public function __construct(Server $server)
    {
        $this->serverId = $server->getKey();
        $this->server = $server;

        parent::__construct();
    }

    public function setDailyDiff(): void
    {
        $playersToday = ServerStatus::select('players_online', 'created_at')
            ->where('online', true)
            ->where('server_id', $this->serverId)
            ->where('online', true)
            ->whereDay('created_at', Carbon::today())
            ->get()
            ->map(function ($el) {
                return $el->players_online;
            });

        $averagePlayersToday = $playersToday->average();

        $playersYesterday = ServerStatus::select('players_online', 'created_at')
            ->where('online', true)
            ->where('server_id', $this->serverId)
            ->where('online', true)
            ->whereDay('created_at', Carbon::yesterday())
            ->get()
            ->map(function ($el) {
                return $el->players_online;
            });

        $averagePlayersYesterday = $playersYesterday->average();

        $this->dailyDiff = $playersYesterday
            ? round(Percentage::differenceBetween($averagePlayersYesterday, $averagePlayersToday), 2)
            : null;

        $this->isDailyDiffPositive = $this->dailyDiff > 0;
    }

    public function setGraphData(): void
    {
        $monthlyPlayersByDay = ServerStatus::select('players_online', 'created_at')
            ->where('server_id', $this->serverId)->where('online', true)
            ->where('created_at', '>=', Carbon::today()->subMonth())
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('d');
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

        // <dd($this->graphData);
    }

    public function setTotal(): void
    {
        $this->total = $this->server->latest_status->players_online;
    }

    public function setMetaData(): void {
        $this->metaData = ['serverName' => $this->server->name];
    }
}

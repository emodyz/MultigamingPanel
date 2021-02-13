<?php


namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Dashboard\Contracts\DashboardStats;
use App\Models\User;
use Illuminate\Support\Carbon;
use Mattiasgeniar\Percentage\Percentage;

class UsersStats extends DashboardStats
{
    public function setDailyDiff(): void
    {
        $newUsersToday = User::whereDay('created_at', Carbon::today())->count();
        $newUsersYesterday = User::whereDay('created_at', Carbon::yesterday())->count();

        $this->dailyDiff = $newUsersYesterday
            ? (int)round(Percentage::differenceBetween($newUsersYesterday, $newUsersToday), 2)
            : null;

        $this->isDailyDiffPositive = $this->dailyDiff > 0;
    }

    public function setGraphData(): void
    {
        $monthlyUsersByDay = User::select('created_at')->where('created_at', '>=', Carbon::today()->subMonth())
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('d');
            });

        $countedUsers = $monthlyUsersByDay->map(function ($el) {
            return $el->count();
        });

        if ($countedUsers->values()->count() <= 1) {
            $countedUsers->prepend(0);
        }

        $this->graphData = $countedUsers->values();
    }

    public function setTotal(): void
    {
        $this->total = User::count();
    }
}

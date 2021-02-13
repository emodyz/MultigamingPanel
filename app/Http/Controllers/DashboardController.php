<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Mattiasgeniar\Percentage\Percentage;

class DashboardController extends Controller
{
   public function __invoke(): Response
   {
       $usersStats = $this->getUsersStats();
       return Inertia::render('Dashboard/Dashboard', compact('usersStats'));
   }

   private function getUsersStats()
   {
       $newUsersToday = User::whereDay('created_at', Carbon::today())->count();
       $newUsersYesterday = User::whereDay('created_at', Carbon::yesterday())->count();

       $usersStats = new \stdClass();

       $usersStats->dailyDifferance = (int)round(Percentage::differenceBetween($newUsersYesterday, $newUsersToday), 2);

       $usersStats->isPositive = $usersStats->dailyDifferance > 0;

       $dailyUsers = User::select('created_at')->where('created_at','>=', Carbon::today()->subMonth())
           ->orderBy('created_at')
           ->get()
           ->groupBy(function ($val) {
               return Carbon::parse($val->created_at)->format('d');
           });

       $countedUsers = $dailyUsers->map(function ($el) {
           return $el->count();
       });

       $usersStats->graphData = $countedUsers->values();

       $usersStats->total = User::count();
       return $usersStats;
   }
}

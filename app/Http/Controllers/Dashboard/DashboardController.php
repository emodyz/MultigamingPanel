<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Server;
use App\Models\ServerStatus;
use App\Models\User;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;
use Mattiasgeniar\Percentage\Percentage;

class DashboardController extends Controller
{
    //TODO: endpoint for async stats
   public function __invoke(): Response
   {
       // TODO: Check for authorization to vue stats on the dashboard
       $usersStats = new UsersStats();

       $serversStats = collect();
       foreach (Server::online() as $server)
       {
           $serversStats->push(new ServerStats($server));
       }

       return Inertia::render('Dashboard/Dashboard', compact('usersStats', 'serversStats'));
   }

   private function test()
   {
       //
   }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;
use Mattiasgeniar\Percentage\Percentage;

class DashboardController extends Controller
{
   public function __invoke(): Response
   {
       // TODO: Check for authorization to vue stats on the dashboard
       $usersStats = new UsersStats();
       return Inertia::render('Dashboard/Dashboard', compact('usersStats'));
   }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Emodyz\Cerberus\Cerberus;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(): \Inertia\Response
    {
        $user = \Auth::user();



        if ($user->can('*')) {
            $users = User::all('id', 'email', 'name', 'profile_photo_path', 'role', 'email_verified_at','created_at');
            return Inertia::render('Admin/Dashboard', [
                'users' => $users,
            ]);
        } elseif ($user->can('admin-users-index')) {
            $users =  User::where('role', '!=', 'owner')->get();
            return Inertia::render('Admin/Dashboard', [
                'users' => $users,
            ]);
        }

        return Inertia::render('Admin/Dashboard', [
            'users' => null,
        ]);
    }
}

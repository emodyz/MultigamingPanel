<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Emodyz\Cerberus\Cerberus;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(Request $request): \Inertia\Response
    {
        /*
        $user = \Auth::user();

        if ($user->can('*')) {
            $users = User::select('id', 'email', 'name', 'profile_photo_path', 'role', 'email_verified_at','created_at')->paginate(5);
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
        ]);*/

        $initialSearch = $request->query('search', '');

        $userQuery = User::query()
            ->select('id', 'email', 'name', 'profile_photo_path', 'role', 'email_verified_at','created_at')
            ->when($request->filled('search'),function($query) use ($initialSearch){
                $query->where('name','LIKE','%'.$initialSearch.'%')
                    ->orWhere('email','LIKE','%'.$initialSearch.'%')
                    ->orWhere('role','LIKE','%'.$initialSearch.'%');
            });

        $users = $userQuery
            ->paginate(10)
            ->onEachSide(2)
            ->appends(request()->only(['search']));


        return Inertia::render('Admin/Dashboard',compact('users', 'initialSearch'));
    }
}

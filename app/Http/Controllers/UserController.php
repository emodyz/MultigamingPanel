<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): \Inertia\Response
    {
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

        $totalItemCount = $users->total();

        foreach ($users as $user) {
            $user->roleName = config('cerberus.roles.' . $user->role . '.displayName');
        }


        return Inertia::render('Users/Index',compact('users', 'initialSearch', 'totalItemCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(Request $request, User $user): Response
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user): Response
    {
        //
    }
}

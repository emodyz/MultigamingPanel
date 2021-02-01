<?php

namespace App\Http\Controllers;

use App\Actions\Emodyz\Users\EditUser;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:users-index', ['only' => ['index']]);

        $this->middleware('can:users-create', ['only' => ['create', 'store']]);

        $this->middleware('can:users-edit', ['only' => ['edit', 'update']]);

        $this->middleware('can:users-edit_account', ['only' => ['updateAccount']]);

        $this->middleware('can:users-destroy', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): \Inertia\Response
    {
        $orderBy = $request->query('orderBy');

        $initialSearch = $request->query('search', '');

        $userQuery = User::query()
            ->select('id', 'email', 'name', 'profile_photo_path', 'role', 'email_verified_at', 'created_at')
            ->when($request->filled('search'), function ($query) use ($initialSearch) {
                $query->where('name', 'LIKE', '%' . $initialSearch . '%')
                    ->orWhere('email', 'LIKE', '%' . $initialSearch . '%')
                    ->orWhere('role', 'LIKE', '%' . $initialSearch . '%');
            })
            ->when($request->filled('orderBy'), function ($query) use ($orderBy) {
                $orderByKey = $orderBy['key'];
                $orderByDirection = $orderBy['direction'];
                $query->orderBy($orderByKey === 'roleName' ? 'role' : $orderByKey, $orderByDirection);
            });

        $users = $userQuery
            ->paginate(10)
            ->onEachSide(2)
            ->appends(request()->only(['search']));

        $totalItemCount = $users->total();

        foreach ($users as $user) {
            $user->roleName = config('cerberus.roles.' . $user->role . '.displayName');
        }

        return Inertia::render('Users/Index', compact('users', 'initialSearch', 'totalItemCount'));
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
     * @return \Inertia\Response
     */
    public function edit(User $user): \Inertia\Response
    {
        $userBeingEdited = $user;

        $roles = collect(config('cerberus.roles'));

        return Inertia::render('Users/Edit', compact('userBeingEdited', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @param EditUser $editor
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, User $user, EditUser $editor): RedirectResponse
    {
        $editor->editUserProfile($user, $request->all());

        flash('Profile Information', $user->getAttribute('name') . '\'s profile has been successfully updated!')->success();
        return back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @param EditUser $editor
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function updateAccount(Request $request, User $user, EditUser $editor): RedirectResponse
    {
        $editor->editUserAccount($user, $request->all());

        flash('Account Information', $user->getAttribute('name') . '\'s account has been successfully updated!')->success();
        return back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        flash('User Deleted', $user->getAttribute('name') . '\'s account has been successfully deleted!')->danger();
        return back(303);
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function destroyAvatar(User $user): RedirectResponse
    {
        $user->deleteProfilePhoto();

        flash('Profile Photo', $user->getAttribute('name') . '\'s avatar has been reset!')->warning();

        return back(303);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    /**
     * @param  Request  $request
     * @param  CreateNewUser  $store
     * @return UserResource|JsonResponse|object
     */
    public function __invoke(Request $request, CreateNewUser $store)
    {
        $user = $store->create($request->all());

        return UserResource::make($user);
    }
}

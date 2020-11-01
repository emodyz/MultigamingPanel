<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    /**
     * @param Request $request
     * @return UserResource|\Illuminate\Http\JsonResponse|object
     */
    public function __invoke(Request $request)
    {
        $user = app(CreateNewUser::class)->create($request->all());

        return UserResource::make($user)
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}

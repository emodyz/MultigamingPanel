<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ServerController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
   Route::post('login', LoginController::class);
   Route::post('register', RegisterController::class);

   Route::group(['prefix' => 'password'], function () {
       Route::post('forgot', ForgotPasswordController::class);
   });
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    // User
    Route::get('/user', function (Request $request) {
        return UserResource::make($request->user());
    });

    // Servers
    Route::resource('servers', ServerController::class);

    /**
     * Cerberus
     * todo: move this in a controller located inside the cerberus package!
     */

    Route::get('cerberus/authorizations', fn() => response()->json(config('cerberus.authorizations')))->name('cerberus.authorizations');
    Route::get('cerberus/authorizations/check/{ability}', function (Request $request, $ability) {
        return 'lol';
        // return response()->json($request->user()->can($ability));
    })->name('cerberus.authorizations.check');
});

<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ModPackController;
use App\Http\Controllers\ModPackServerController;
use App\Http\Controllers\ServerController;
use App\Http\Resources\UserResource;
use App\Models\Article;
use App\Models\Server;
use App\Settings\VoiceSettings;
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
    Route::resource('/servers', ServerController::class);
    Route::get('/servers/{server}/modpacks', [ServerController::class, 'modpacks']);

    // ModPacks
    Route::resource('/modpacks', ModPackController::class);

    // Modpack Server
    Route::post('/modpacks/{modpack}/servers/{server}', [ModPackServerController::class, 'attach']);
    Route::delete('/modpacks/{modpack}/servers/{server}', [ModPackServerController::class, 'detach']);

    // Articles
    Route::get('/servers/{server}/articles', function (Server $server) { return response()->json($server->articles); });
    Route::get('/servers/{server}/articles/latest/{n?}', function (Server $server, $n = 5) {
        return response()->json($server->articles()->where('status', 'published')->latest()->take($n)->get());
    });

    // Settings
    Route::get('/settings/voice', fn(VoiceSettings $settings) => $settings->toArray())->name('settings.show.voice');

});
// Articles
Route::get('/articles', function () { return response()->json(Article::getAllGlobalArticles()); });
Route::get('/articles/latest/{n?}', function ($n = 5) { return response()->json(Article::getLastGlobalArticles($n)); });

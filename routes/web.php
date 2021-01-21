<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModPackController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

Route::get('/flash', function (Request $request) {
    // $request->session()->flash('status', ['type' => 'success', 'title' => 'Article Created', 'message' => str_repeat('Your new article has been created.', 5) ]);
    flash('test', str_repeat('Your new article has been created.', 5))->success();
    return back();
})->name('flash');

Route::group(['middleware' => 'auth:sanctum'], function () {

    // ModPacks
    Route::resource('modpacks', ModPackController::class);
    Route::get('/modpacks/{modpack}/update', [ModPackController::class, 'showUpdate'])->name('modpacks.update.show');
    Route::post('/modpacks/{modpack}/update', [ModPackController::class, 'startUpdate'])->name('modpacks.update.start');
    Route::delete('/modpacks/{modpack}/update', [ModPackController::class, 'cancelUpdate'])->name('modpacks.update.cancel');
    // Users
    Route::resource('users', UserController::class);
    route::delete('users/{user}/avatar', [UserController::class, 'destroyAvatar'])->name('users.destroy.avatar');
    route::put('users/{user}/account', [UserController::class, 'updateAccount'])->name('users.update.account');
    // Articles
    Route::resource('articles', ArticleController::class);
    // Servers
    Route::resource('servers', ServerController::class);

});

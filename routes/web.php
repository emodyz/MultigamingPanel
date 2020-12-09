<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ModpackController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth:sanctum'], function () {

    // Modpacks
    Route::resource('modpacks', ModpackController::class);
    Route::post('/modpacks/{modpack}/update', [ModpackController::class, 'startUpdate'])->name('modpacks.update.start');
    Route::delete('/modpacks/{modpack}/update', [ModpackController::class, 'cancelUpdate'])->name('modpacks.update.cancel');
    Route::resource('users', UserController::class);
    route::delete('users/{user}/avatar', [UserController::class, 'destroyAvatar'])->name('users.destroy.avatar');
});



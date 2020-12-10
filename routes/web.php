<?php

use App\Http\Controllers\UserController;
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

Route::middleware(['auth:sanctum', 'verified', 'can:dashboard,users-index'])->group(function () {
    Route::resource('users', UserController::class);
    route::delete('users/{user}/avatar', [UserController::class, 'destroyAvatar'])->name('users.destroy.avatar');
    route::put('users/{user}/account', [UserController::class, 'updateAccount'])->name('users.update.account');
});

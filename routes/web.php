<?php

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

Route::redirect('/', 'home');

Auth::routes(['verify' => true]);

Route::group(['middleware' => 'auth'], function () {

    Route::resource('users', 'UserController');
    Route::put('locale/{locale}', 'LocaleController@update')->name('locale.update');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard')->middleware('auth');

    Route::resource('servers', 'ServerController');

    /************************************/
    /*              SETTINGS            */
    /************************************/
    Route::group(['prefix' => 'settings'], function () {
        Route::get('launcher', function () {
            return view('settings/launcher/launcher');
        })->name('settings.launcher.index');
    });
});



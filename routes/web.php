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

Auth::routes();

/* Routes for guests */
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    /* Routes for oAuth */
    Route::get('auth/{provider}', 'App\Http\Controllers\Auth\LoginController@redirectToProvider');
    Route::get('auth/{provider}/callback', 'App\Http\Controllers\Auth\LoginController@handleProviderCallback');
});

/* Routes for authenticated users */
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

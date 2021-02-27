<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

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

/* Routes for authentication and email verification */
Auth::routes(['verify' => true]);

/* Routes for guests */
Route::group(['middleware' => 'guest'], function () {

    /* Routes for oAuth */
    Route::get('auth/{provider}', 'App\Http\Controllers\Auth\LoginController@redirectToProvider');
    Route::get('auth/{provider}/callback', 'App\Http\Controllers\Auth\LoginController@handleProviderCallback');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

/* Routes for authenticated and verified users */
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::resource('posts', PostController::class);
});

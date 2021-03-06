<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
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

/* Routes for authentication and email verification */

Auth::routes(['verify' => true]);

/* Routes for guests */
Route::group(['middleware' => 'guest'], function () {
    /* Routes for oAuth */
    Route::get('auth/{provider}', [LoginController::class, 'redirectToProvider'])->name('oauth');
    Route::get('auth/{provider}/callback', [LoginController::class, 'handleProviderCallback']);
});

/* Routes for authenticated and verified users */
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::resource('/posts', PostController::class);
    Route::resource('/replies', PostReplyController::class)->only(['show']);
    Route::post('/replies/store/{post}/{postReply?}', [PostReplyController::class, 'store'])->name('replies.store');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');

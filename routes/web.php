<?php

use App\Http\Livewire\UploadFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostReplyController;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/replies/store/{post}/{postReply?}', [PostReplyController::class, 'store'])->name('replies.store');
Route::resource('/posts', PostController::class);
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');
Route::resource('/users', UserController::class);
Route::get('/users/reset_avatar/{users}', [UserController::class, 'reset_avatar'])->name('users.reset_avatar');
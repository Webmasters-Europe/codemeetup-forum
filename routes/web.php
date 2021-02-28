<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
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
    Route::get('auth/{provider}', [LoginController::class, 'redirectToProvider']);
    Route::get('auth/{provider}/callback', [LoginController::class, 'handleProviderCallback']);
});

/* Routes for authenticated and verified users */
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');

Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

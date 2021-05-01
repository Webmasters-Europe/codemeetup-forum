<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostReplyController;
use App\Http\Controllers\UserController;
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

Auth::routes(['verify' => true]);

Route::group(['middleware' => 'guest'], function () {
    Route::get('auth/{provider}', [LoginController::class, 'redirectToProvider'])->name('oauth');
    Route::get('auth/{provider}/callback', [LoginController::class, 'handleProviderCallback']);
});

Route::get('/', HomeController::class)->name('home');
Route::get('/imprint', [HomeController::class, 'imprint'])->name('imprint');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/sendmail', [HomeController::class, 'sendmail'])->name('sendmail');

Route::post('/replies/store/{post}/{postReply?}', [PostReplyController::class, 'store'])->name('replies.store');
Route::resource('/posts', PostController::class)->only(['index', 'show']);
Route::get('/posts/create/{category}', [PostController::class, 'create'])->name('posts.create');
Route::get('/category/{category}', CategoryController::class)->name('category.show');
Route::resource('/users', UserController::class)->only(['show', 'edit', 'update']);
Route::get('/users/reset_avatar/{users}', [UserController::class, 'reset_avatar'])->name('users.reset_avatar');

Route::prefix('admin-area')->middleware(['auth'])->group(__DIR__.'/admin.php');

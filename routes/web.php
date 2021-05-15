<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostReplyController;
use App\Http\Controllers\UserController;
use App\Models\Setting;
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

Route::post('/replies/store/{post}/{postReply?}', [PostReplyController::class, 'store'])->name('replies.store');
Route::delete('/replies/{postReply}', [PostReplyController::class, 'destroy'])->name('replies.destroy');
Route::patch('/replies/{postReply}', [PostReplyController::class, 'update'])->name('replies.update');

Route::resource('/posts', PostController::class)->only(['index', 'show', 'destroy', 'update']);
Route::get('/posts/create/{category}', [PostController::class, 'create'])->name('posts.create');
Route::get('/category/{category}', CategoryController::class)->name('category.show');
Route::resource('/users', UserController::class)->only(['show', 'edit', 'update']);
Route::get('/users/reset_avatar/{users}', [UserController::class, 'reset_avatar'])->name('users.reset_avatar');

/* Route::get('config', function () {
    $setting = app()->make(Setting::class);
    $setting->primary_color = '#eff';
    $setting->save();

    return config('app.settings.primary_color');
}); */

Route::prefix('admin-area')->middleware(['auth'])->group(__DIR__ . '/admin.php');

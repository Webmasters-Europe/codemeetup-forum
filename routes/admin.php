<?php

use App\Http\Controllers\SettingController;

Route::get('/', function () {
    return view('admin-area.dashboard');
})->middleware('can:access admin area')->name('admin-area.dashboard');

Route::get('categories', function () {
    return view('admin-area.categories');
})->middleware('can:admin categories')->name('admin-area.categories');

Route::get('users', function () {
    return view('admin-area.users');
})->middleware('can:admin users')->name('admin-area.users');

Route::get('posts', function () {
    return view('admin-area.posts');
})->middleware('can:admin posts')->name('admin-area.posts');

Route::get('permissions', function () {
    return view('admin-area.permissions');
})->middleware('can:admin permissions')->name('admin-area.permissions');

Route::get('settings', [SettingController::class, 'index'])->middleware('can:admin settings')->name('admin-area.settings');
Route::put('settings', [SettingController::class, 'update'])->middleware('can:admin settings')->name('admin-area.settings.update');

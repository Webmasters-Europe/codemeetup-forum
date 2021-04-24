<?php

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

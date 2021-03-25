<?php

Route::get('/admin-area', function () {
    if (auth()->user()->can('access admin area')) {
        return view('admin-area.dashboard');
    }
    abort('403');
})->name('admin-area.dashboard');

Route::get('/admin-area/categories', function () {
    if (auth()->user()->can('admin categories')) {
        return view('admin-area.categories');
    }
    abort('403');
})->name('admin-area.categories');

Route::get('/admin-area/users', function () {
    if (auth()->user()->can('admin users')) {
        return view('admin-area.users');
    }
    abort('403');
})->name('admin-area.users');

Route::get('/admin-area/posts', function () {
    if (auth()->user()->can('admin posts')) {
        return view('admin-area.posts');
    }
    abort('403');
})->name('admin-area.posts');

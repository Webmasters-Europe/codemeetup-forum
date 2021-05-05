@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin-area.dashboard') }}">Admin Area</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>

    <h1>Dashboard</h1>

    @can('admin categories')
        <a class="btn my-2" href="{{ route('admin-area.categories') }}" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};">Administrate Categories</a>
    @endcan

    @can('admin users')
        <a class="btn my-2" href="{{ route('admin-area.users') }}" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};">Administrate Users</a>
    @endcan

    @can('admin posts')
        <a class="btn my-2" href="{{ route('admin-area.posts') }}" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};">Administrate Posts</a>
    @endcan

    @can('admin permissions')
        <a class="btn my-2" href="{{ route('admin-area.permissions') }}" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};">Administrate Permissions</a>
    @endcan

    @can('admin settings')
        <a class="btn my-2" href="{{ route('admin-area.settings') }}" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};">Settings</a>
    @endcan

    <div class="row border my-2 p-2 no-gutters">
        <div class="col-12">
            @livewire('admin-area-dashboard')
        </div>
    </div>

@endsection

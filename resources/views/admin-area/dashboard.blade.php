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
        <a class="btn btn-dark my-2" href="{{ route('admin-area.categories') }}">Administrate Categories</a>
    @endcan

    @can('admin users')
        <a class="btn btn-dark my-2" href="{{ route('admin-area.users') }}">Administrate Users</a>
    @endcan

    @can('admin posts')
        <a class="btn btn-dark my-2" href="{{ route('admin-area.posts') }}">Administrate Posts</a>
    @endcan

    @can('admin permissions')
        <a class="btn btn-dark my-2" href="{{ route('admin-area.permissions') }}">Administrate Permissions</a>
    @endcan

    @can('admin settings')
        <a class="btn btn-dark my-2" href="{{ route('admin-area.settings') }}">Settings</a>
    @endcan

    <div class="row border my-2 p-2 no-gutters">
        <div class="col-12">
            Show something interesting here... Maybe how many users joined the forum the last x days, how many posts were created and stuff like that.
        </div>
    </div>

@endsection

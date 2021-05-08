@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin-area.dashboard') }}">Admin Area</a></li>
            <li class="breadcrumb-item active" aria-current="page">Permissions</li>
        </ol>
    </nav>

    <h1>Administrate Permissions</h1>

    @livewire('admin-area-permissions')

@endsection

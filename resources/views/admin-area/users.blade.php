@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin-area.dashboard') }}">{{ __('Admin Area') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Users') }}</li>
        </ol>
    </nav>

    <h1>{{ __('Administrate Users') }}</h1>

    @livewire('admin-area-users')

@endsection

<x-table-modal-event-listeners/>

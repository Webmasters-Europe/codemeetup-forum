@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin-area.dashboard') }}">{{__('Admin Area') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Categories') }}</li>
        </ol>
    </nav>

    <h1>{{ __('Administrate Categories') }}</h1>

    @livewire('admin-area-categories')

@endsection

<x-table-modal-event-listeners/>

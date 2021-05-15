@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin-area.dashboard') }}">Admin Area</a></li>
            <li class="breadcrumb-item active" aria-current="page">ShowPost</li>
        </ol>
    </nav>

    <h1>Administrate SinglePost</h1>
 
    @livewire('admin-area-single-post', ['postId' => $postId])
    
@endsection
<x-table-modal-event-listeners/>
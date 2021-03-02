@extends('layouts.app')

@section('content')

        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.show', $post->category->id) }}">{{ $post->category->name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
        </ol>
        </nav>

        <h1>{{ $post->title }}</h1>
        <div>
            {{ $post->content }}
        </div>
        <div>by {{ $post->user->username }}</div>
        <div>created at {{ $post->created_at->format('d.m.Y H:i:s') }}</div>

@endsection

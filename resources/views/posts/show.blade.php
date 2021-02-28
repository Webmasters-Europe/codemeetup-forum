@extends('layouts.app')

@section('content')
    <div class="col-lg-9 px-4">
        <h1>{{ $post->title }}</h1>
        <div>
            {{ $post->content }}
        </div>
        <div>by {{ $post->user->username }}</div>
        <div>created at {{ $post->created_at->format('d.m.Y H:i:s') }}</div>
    </div>
@endsection

@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$category->name}}</li>
        </ol>
    </nav>

    <h1>{{$category->name}}</h1>

    @can('create posts')
        <a class="btn btn-dark my-2" href="{{ route('posts.create', $category) }}">Create Post</a>
    @endcan

    @forelse($posts as $post)
        <div class="row border my-2 p-2 no-gutters">
            <div class="col-3 col-lg-4">
                <a href="{{route('posts.show', $post)}}">
                    <h1>{{$post->title}}</h1>
                </a>
            </div>
            <div class="col-3 col-lg-4">
                by
                @if ($post->user->trashed())
                    a deleted user
                @else
                    <a href=" {{ route('users.show', $post->user) }}">{{$post->user->username}}</a>
                @endif
                at {{ $post->created_at->format('d.m.Y H:i:s') }}
            </div>
            <div class="col-3 col-lg-2">
                {{$post->reply_count}} Replies
            </div>
        </div>
    @empty
        <div class="row border my-2 p-2 no-gutters">
            No posts found in this category.
        </div>
    @endforelse
    {{ $posts->firstItem()}} - {{ $posts->lastItem() }} from {{ $posts->total() }} results
    {{ $posts->links() }}

@endsection

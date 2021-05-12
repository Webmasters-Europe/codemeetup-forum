@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$category->name}}</li>
        </ol>
    </nav>

    <h1>{{$category->name}}</h1>

    @can('create posts')
        <a class="btn my-2" href="{{ route('posts.create', $category) }}" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};">{{ __('Create Post') }}</a>
    @endcan

    @forelse($posts as $post)
        <div class="row border my-2 p-2 no-gutters">
            <div class="col-3 col-lg-4">
                <a href="{{route('posts.show', $post)}}">
                    <h3>{{$post->title}}</h3>
                </a>
            </div>
            <div class="col-3 col-lg-4">
                {{ __('by') }}
                @if ($post->user->trashed())
                    {{ __('a deleted user') }}
                @else
                    <a href=" {{ route('users.show', $post->user) }}">{{$post->user->username}}</a>
                @endif
                {{__('at') }} {{ $post->created_at->format('d.m.Y H:i:s') }}
            </div>
            <div class="col-3 col-lg-2">
                @if ($post->reply_count === 1)
                1 {{ __('reply') }}
                @else 
                {{$post->reply_count}} {{ __('replies') }}
                @endif
            </div>
        </div>
    @empty
        <div class="row border my-2 p-2 no-gutters">
            {{ __('No posts found in this category.') }}
        </div>
    @endforelse
    {{ $posts->firstItem()}} - {{ $posts->lastItem() }} {{ __('from') }} {{ $posts->total() }}
    {{ $posts->links() }}

@endsection

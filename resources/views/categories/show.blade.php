@extends('layouts.app')

@section('content')

    <div class="col-lg-9 px-4">

        <h1>{{$category->name}}</h1>

        @if (count($posts) === 0)
            <div class="row border my-2 p-2 no-gutters">
                No posts found in this category.
            </div>
        @else
            @foreach($posts as $post)
                <div class="row border my-2 p-2 no-gutters">
                    <div class="col-3 col-lg-4">
                        <a href="{{route('posts.show', $post)}}">
                            <h1>{{$post->title}}</h1>
                        </a>
                    </div>
                    <div class="col-3 col-lg-4">
                        by {{$post->user->username}} at {{ $post->created_at->format('d.m.Y H:i:s') }}
                    </div>
                    <div class="col-3 col-lg-2">
                        # replies
                    </div>
                </div>
            @endforeach
        @endif
    </div>

@endsection

@extends('layouts.app')

@section('content')

        <main id="main">
        @if (count($categories) === 0)
            <div class="row border my-2 p-2 no-gutters">
                No categories found.
            </div>
        @endif

        @foreach($categories as $category)
            <div class="row border my-2 p-2 no-gutters d-flex align-items-center">
                <div class="col-2 col-lg-1 icon"><i class="fas fa-folder-open fa-3x"></i></div>
                <div class="col-8 col-lg-6">
                    <a href="{{route('category.show', $category)}}">
                    <h3 class="m-1">{{$category->name}}</h3>
                    <p class="m-1">{{$category->description}}</p>
                    </a>
                </div>
                <div class="col-2 col-lg-1 posts-count">
                    @if ($category->posts_count === 1)
                    <p>1 post</p>
                    @else
                    <p>{{$category->posts_count}} posts</p>
                    @endif
                </div>
                <div class="col-12 col-lg-4">
                    @if ($category->latestPost)
                        <a href="{{ route('posts.show', $category->latestPost->id)}}"><h6 class="my-0">{{ $category->latestPost->title }}</h6></a>
                        <div>
                            <small class="text-muted">
                                by
                                @if ($category->latestPost->user->trashed())
                                    a deleted user
                                @else
                                    <a href=" {{ route('users.show', $category->latestPost->user) }}">{{$category->latestPost->user->username}}</a>
                                @endif
                            </small>
                            <small class="text-muted">{{ $category->latestPost->created_at->diffForHumans() }}</small>
                        </div>
                    @else
                        <p>No posts yet...</p>
                    @endif
                </div>
            </div>
        @endforeach
        {{ $categories->firstItem()}} - {{ $categories->lastItem() }} from {{ $categories->total() }} results
        {{ $categories->links() }}

        </main>

@endsection

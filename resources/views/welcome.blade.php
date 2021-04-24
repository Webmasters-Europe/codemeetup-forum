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
                <div class="col-1 col-lg-1 icon"><i class="fas fa-folder-open fa-3x"></i></div>
                <div class="col-8 col-lg-6">
                    <a href="{{route('category.show', $category)}}">
                    <h3 class="m-1">{{$category->name}}</h3>
                    <p class="m-1">{{$category->description}}</p>
                    </a>
                </div>
                <div class="col-3 col-lg-1">
                    @if ($category->posts_count === 1)
                    <p>1 post</p>
                    @else
                    <p>{{$category->posts_count}} posts</p>
                    @endif
                </div>
                <div class="col-12 col-lg-4">
                    Last reply in this category (the same view as in "last entries section")
                </div>
            </div>
        @endforeach
        {{ $categories->firstItem()}} - {{ $categories->lastItem() }} from {{ $categories->total() }} results
        {{ $categories->links() }}

        </main>

@endsection

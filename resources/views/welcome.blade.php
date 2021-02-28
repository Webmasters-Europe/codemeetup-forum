@extends('layouts.app')

@section('content')

        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Home</li>
        </ol>
        </nav>

        @if (count($categories) === 0)
            <div class="row border my-2 p-2 no-gutters">
                No categories found.
            </div>
        @endif

        @foreach($categories as $category)
            <div class="row border my-2 p-2 no-gutters">
                <div class="col-3 col-lg-2">
                    <img src="https://picsum.photos/40" alt="image">
                </div>
                <div class="col-6 col-lg-4">
                    <a href="{{route('category.show', $category)}}">
                        <h1>{{$category->name}}</h1>
                    </a>
                </div>
                <div class="col-3 col-lg-2">
                    {{$category->posts_count}}
                </div>
                <div class="col-12 col-lg-4">
                    <p>
                        {{$category->description}}
                    </p>
                </div>
            </div>
        @endforeach

@endsection

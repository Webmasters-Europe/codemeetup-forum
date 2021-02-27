@extends('layouts.app')


@section('content')

<div class="col-lg-10">

    @foreach($categories as $category)
        <div class="row border my-2 py-2 pl-2 no-gutters">
            <div class="col-3 col-lg-2">
                <img src="https://picsum.photos/40" alt="image">
            </div>
            <div class="col-6 col-lg-4">
                <h1>{{$category->name}}</h1>
            </div>
            <div class="col-3 col-lg-2">
                666
            </div>
            <div class="col-12 col-lg-4">
                <p>
                   {{$category->description}}
                </p>
            </div>
        </div>
    @endforeach
</div>
@endsection

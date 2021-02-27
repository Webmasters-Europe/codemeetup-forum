@extends('layouts.app')
@push('styles')
    @media screen and (max-width:480px ){
    .w-50 {
    width: 100%!important;
    }
    }
@endpush

@section('content')

    <div class="col-lg-10 border my-2 py-2">

        <form action="{{ route('posts.store') }}" method="POST" class="w-50">
            @csrf

            <div class="form-group p-2">
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id" required>
                    <option disabled selected>Choose category</option>
                    @foreach($categories as $category)
                        <option {{ old('category_id') == $category->id ? 'selected' : '' }} value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group p-2">
                <label for="postTitle">Title</label>
                <input type="text" value="{{ old('title') }}" class="form-control" id="postTitle" name="title" placeholder="Post title" required>
            </div>
            <div class="form-group p-2">
                <label for="postContent">Post</label>
                <textarea class="form-control" id="postContent" name="content" rows="6" required>{{ old('content') }}</textarea>
            </div>

            <button type="submit" class="btn btn-dark btn-lg ml-2">Create post</button>
        </form>
    </div>
@endsection

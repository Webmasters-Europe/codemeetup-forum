@extends('layouts.app')
@push('styles')
    <style>
        @media screen and (max-width:480px ){
            .w-50 {
                width: 100%!important;
            }
        }
    </style>
@endpush

@section('content')

          <form action="{{ route('posts.store') }}" method="POST" class="w-50">
              @csrf

              <div class="form-group p-2">
                  <label for="categoryId">Category</label>
                  <select id="categoryId" name="category_id" required>
                      <option disabled selected>Choose category</option>
                      @foreach($categories as $category)
                          <option {{ old('category_id') == $category->id ? 'selected' : '' }} value="{{$category->id}}">{{$category->name}}</option>
                      @endforeach
                  </select>
              </div>

              <div class="form-group p-2">
                <label for="postTitle">Title</label>
                <input type="text" value="{{ old('title') }}" class="form-control" id="postTitle" name="title" placeholder="Post title" >
              </div>

              <div class="form-group p-2">
                <label for="postContent">Post</label>
                <x-easy-mde name="content" :options="['hideIcons' => ['image']]">{{ old('content') }}</x-easy-mde>
              </div>

              <button type="submit" class="btn btn-dark btn-lg ml-2">Create post</button>
          </form>

@endsection

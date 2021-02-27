@extends('layouts.app')
@section('content')
        
                <div class="col-lg-10 border my-2 py-2">
                                         
                    <form action="{{ route('posts.store') }}" method="POST" class="w-50">
                        @csrf
                        <div class="form-group">
                          <label for="postTitle">Title</label>
                          <input type="text" class="form-control" id="postTitle" name="title" placeholder="Post title" required>
                        </div>
                        <div class="form-group">
                          <label for="postContent">Post</label>
                          <textarea class="form-control" id="postContent" name="content" rows="6"></textarea>
                        </div>
                                                                
                        <button type="submit" class="btn btn-dark btn-lg">Create post</button>  
                    </form>                      
                </div>
@endsection
@extends('layouts.app')
@push('styles')
                @media screen and (max-width:480px ){
                .w-50 {
                    width: 100%!important;
                }
            }        
@endpush

@section('content')


<div class="col-lg-9 border my-2 py-2">
                                         
                    <form action="{{ route('posts.store') }}" method="POST" class="w-50">
                        @csrf
                        <div class="form-group p-2">
                          <label for="postTitle">Title</label>
                          <input type="text" class="form-control" id="postTitle" name="title" placeholder="Post title" >
                        </div>
                        <div class="form-group p-2">
                          <label for="postContent">Post</label>
                          <textarea class="form-control" id="postContent" name="content" rows="6"></textarea>
                        </div>
                                                                
                        <button type="submit" class="btn btn-dark btn-lg ml-2">Create post</button>  
                    </form>                      
                </div>
@endsection
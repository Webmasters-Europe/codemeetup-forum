@extends('layouts.app')

@section('content')

        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.show', $post->category->id) }}">{{ $post->category->name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
        </ol>
        </nav>

        <h1>{{ $post->title }}</h1>
        <div>
            {{ $post->content }}
        </div>
        <div>by {{ $post->user->username }}</div>
        <div>created at {{ $post->created_at->format('d.m.Y H:i:s') }}</div>
<hr>
        <!-- begin show PostReplies -->
        <div>
            <h1>Replies:</h1>
            @foreach ($replies as $reply)
                <ul>
                    <li>{{ $reply->content}}</li>
                    by {{ $reply->user->username }}, created at {{ $reply->created_at->format('d.m.Y H:i:s') }}
                </ul>
            @endforeach

            <!-- begin Form for PostReply -->
            <div>
                <form action="{{ route('replies.store', $post) }}" method="POST" class="w-50">
                    @csrf
                    <div class="form-group p-2">
                    <label for="postReplyContent">Write Post Reply:</label>
                    <textarea class="form-control" name="content" rows="6">{{ old('content') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-dark btn-lg ml-2">Create Reply</button>  
                </form>      
            </div> <!-- end Form for PostReply -->
        </div> <!-- end show PostReplies
@endsection

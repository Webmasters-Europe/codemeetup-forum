@extends('layouts.app')

@section('content')

<div class="flex justify-between w-1/2">
    <div class="text-xl mb-5 text-white">{{ $category->name }}</div>
    @can('create posts')
        <a href="{{ route('posts.create', $category) }}" class="items-center">
            <button class="p-1 bg-indigo-100 text-gray-900 hover:text-white hover:bg-gray-400 rounded">
            Create New Post
            </button>
        </a>    
    @endcan
</div>

@forelse($posts as $post)
<section class="w-full text-gray-600 bg-white body-font rounded overflow-hidden flex justify-between mb-2">
    <div class="p-4">
        <a href="{{route('posts.show', $post)}}" class="text-lg font-bold">{{ $post->title }}</a> <br>
        <div class="text-xs">
            by
            @if ($post->user->trashed())
                a deleted user
            @else
                <a href=" {{ route('users.show', $post->user) }}" class="text-indigo-600">{{$post->user->username}}</a>
            @endif
            at {{ $post->created_at->format('d.m.Y H:i:s') }}
        </div>
    </div>
    <div class="text-lg p-4">
        <i class="fas fa-reply mr-2"></i><span class="font-bold mr-2"> {{$post->reply_count}}</span><span class="font-normal">Replies</span>
    </div>
</section>
@empty
  <div class="text-white">
      No posts found in this category.
  </div>
@endforelse
<span class="bg-white p-2 rounded">
    {{ $posts->links() }}
</span>

@endsection

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

        @markdown($post->content)

        <div>by <a href=" {{ route('users.show', $post->user) }}">{{ $post->user->username }}</a></div>
        <div>created at {{ $post->created_at->format('d.m.Y H:i:s') }}</div>

        {{-- begin show all uploads to this post --}}
        <div>
            <p>Images:</p>
            @forelse ($images as $image)
                <img src="{{ asset('storage/'.$image->filename) }}" width="100" alt="">
            @empty
                No uploded images for this post.
            @endforelse
            <p>Files:</p>
            <ul> 
                @forelse ($otherFiles as $otherFile)
                    <li><a href="{{ asset('storage/'.$otherFile->filename) }}">{{ basename($otherFile->filename) }}</a></li>
                @empty
                    No uploded Files for this post.
                @endforelse
            </ul>
        </div>
        {{-- end show all uploads to this post --}}

        @auth
        <div>
            <form action="{{ route('replies.store', $post) }}" method="POST" class="w-50">
                @csrf
                <div class="form-group p-2">
                    <label for="postContent">Reply:</label>
                    <x-easy-mde name="content" :options="['hideIcons' => ['image']]"/>
                </div>
                <button type="submit" class="btn btn-dark btn-lg ml-2">Create Reply</button>
            </form>
        </div>
        @else
            <div class="alert-danger">{{__('Login to leave a reply') }}</div>
        @endauth

        <hr>
        <!-- begin show PostReplies -->

            <div>
                <h1>Replies:</h1>
                @forelse ($replies as $reply)
                <ul class="row border my-2 p-2 no-gutters">
                            <li class="list-unstyled">
                                @markdown($reply->content)
                                by {{ $reply->user->username }}, created at {{ $reply->created_at->format('d.m.Y H:i:s') }}

                                @auth
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#replyModal_{{$reply->id}}">
                                    {{__('Comment') }}
                                </button>
                                @endauth

                            {{-- show reply to reply --}}
                            <x-replies :reply="$reply" :post="$post" />

                            <!-- Begin Modal -->
                            @auth
                            <div class="modal fade" id="replyModal_{{$reply->id}}" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="replyModalLabel">{{__('Leave a comment') }}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('replies.store', [$post, $reply]) }}" method="POST">
                                                @csrf
                                                <x-easy-mde name="content" :options="['hideIcons' => ['image']]">{{ old('content') }}</x-easy-mde>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('Close') }}</button>
                                            <button type="submit" class="btn btn-success">{{__('Save') }}</button>
                                        </div>
                                            </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->
                            @endauth
                        </li>
                    </ul>
                @empty
                    <li class="row border my-2 p-2 no-gutters">
                        No replies found for this post.
                    </li>
                @endforelse

                {{ $replies->links() }}

           </div> <!-- end show PostReplies -->

@endsection

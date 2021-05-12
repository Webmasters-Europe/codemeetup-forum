@extends('layouts.app')

@section('content')

        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.show', $post->category->id) }}">{{ $post->category->name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
        </ol>
        </nav>

        <div class="card">
            <div class="card-body">
                <h1 class="card-title">{{ $post->title }}</h1>
                <div class="card-subtitle mb-2 text-muted">
                    <span class="text-muted">
                        {{ __('by') }}
                        @if ($post->user->trashed())
                            {{ __('a deleted user') }}
                        @else
                            <a href=" {{ route('users.show', $post->user) }}">{{$post->user->username}}</a>
                        @endif
                    </span>
                    <span>{{ __('created at') }} {{ $post->created_at->format('d.m.Y H:i:s') }}</span>
                </div>
                <div class="card-text"> 
                    @markdown($post->content)
                    {{-- begin show all uploads to this post --}}
                    <div>
                        <p>{{ __('Images') }}:</p>
                        @forelse ($images as $image)
                            <img src="{{ asset('storage/'.$image->filename) }}" width="100" alt="">
                        @empty
                            {{ __('No uploded images for this post.') }}
                        @endforelse
                        <p>{{ __('Files') }}:</p>
                        <ul>
                            @forelse ($otherFiles as $otherFile)
                                <li><a href="{{ asset('storage/'.$otherFile->filename) }}">{{ basename($otherFile->filename) }}</a></li>
                            @empty
                                {{ __('No uploded Files for this post.') }}
                            @endforelse
                        </ul>
                    </div>
                    {{-- end show all uploads to this post --}}

                    <hr>
                    <!-- begin show PostReplies -->

                                <h1>{{ __('Replies') }}:</h1>
                            </div>

                            @can('create post replies')
                            <div>
                                <form action="{{ route('replies.store', $post) }}" method="POST">
                                    @csrf
                                    <div class="form-group p-2">
                                        <label for="postContent">{{ __('Write your reply:') }}</label>
                                        <x-easy-mde class="w-100" name="content" :options="['hideIcons' => ['image'], 'minHeight' => '150px']"/>
                                    </div>
                                    <button type="submit" class="btn ml-2" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};">{{ __('Create Reply') }}</button>
                                </form>
                            </div>
                            @else
                            <div>
                                <form action="{{ route('replies.store', $post) }}" method="POST">
                                    @csrf
                                    <div class="form-group p-2">
                                        <label for="postContent">{{ __('Write your reply:') }}</label><br>
                                        <textarea class="w-100 disabled-reply" disabled placeholder="Login to leave a reply"></textarea>
                                    </div>
                                    <button disabled type="submit" class="btn ml-2" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};">{{ __('Create Reply') }}</button>
                                </form>
                            </div>
                            @endcan

                            <div class="card-text">
                                @forelse ($replies as $reply)
                                <ul class="row border my-2 p-2 no-gutters">
                                    <li class="list-unstyled">
                                       <span class="reply"> @markdown($reply->content)</span>

                                       <small class="reply-info text-muted"> by
                                        @if ($reply->user->trashed())
                                            {{ __('a deleted user') }},
                                        @else
                                            <a href=" {{ route('users.show', $reply->user) }}">{{$reply->user->username}}</a>,
                                        @endif
                                        {{ __('created at') }} {{ $reply->created_at->format('d.m.Y H:i:s') }}
                                        </small>

                                        @can('create post replies')
                                        <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#replyModal_{{$reply->id}}" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};">
                                            {{__('Comment') }}
                                        </button>
                                        @endcan

                                        {{-- show reply to reply --}}
                                       
                                        <x-replies :reply="$reply" :post="$post" />
                                       

                                        <!-- Begin Modal -->
                                        @can('create post replies')
                                        <div class="modal fade" id="replyModal_{{$reply->id}}" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="replyModalLabel">{{ __('Leave a comment') }}</h4>
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
                                        @endcan
                                    </li>
                        </ul>
                    @empty
                        <li class="row border my-2 p-2 no-gutters">
                            {{ __('No replies found for this post.') }}
                        </li>
                    @endforelse

                    {{ $replies->links() }}

                    <!-- end show PostReplies -->
                </div>
            </div>
        </div>

@endsection

@extends('layouts.app')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $user->username }}</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-4">
        <div id="profile-card" class="card mb-4">
            @if ($user->avatar)
                <img class="card-img-top pt-4 px-4 pb-0" src="{{ asset('storage/'.$user->avatar) }}" width="100px" alt="Avatar von  {{ $user->username }}">
            @else
                <img class="card-img-top p-4" src="{{ asset('icons/blank-profile-picture.png') }}" width="100px" alt="Avatar von  {{ $user->username }}">
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $user->username }}</h5>
                <p class="card-text">{{ __('E-Mail') }}: {{ $user->email }} </p>
                <p class="card-text">{{ __('Name') }}: {{ $user->name }} </p>
                @can('edit own profile')
                    @if(auth()->user()->is($user))
                        <div>
                            <a href="{{ route('users.edit', $user) }}" type="button" class="btn btn-block m-0 mt-4" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};">{{ __('Edit Your Profile') }}</a>
                        </div>
                    @endif
                @endcan
            </div>
        </div>
    </div>
    <div class="col-md-8">
        @if(auth()->check() && auth()->user()->is($user))
        <div class="card mb-4">
            <h5 class="card-header">{{ __('Notifications of') }} {{ $user->username }}</h5>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse ($notifications as $notification)
                        <li class="list-group-item">
                            {{ $notification->data['postReply']['content'] }}<br>
                            <span class="small">created {{ $notification->created_at }}</span> <br>
                            <a href="{{ route('posts.show', $notification->data['postReply']['post_id']) }}" class="btn btn-sm mt-2">View</a>
                        </li>
                    @empty
                        <p>{{ __('No Notifications.') }}</p>
                    @endforelse
                </ul>
            </div>
            <div class="card-footer">
                @if ($notifications->isNotEmpty())
                    {{ $notifications->firstItem()}} - {{ $notifications->lastItem() }} {{ __('from') }} {{ $notifications->total() }}
                    {{ $notifications->links() }}
                @endif
            </div>
        </div>
    @endif


        <div class="card">
            <h5 class="card-header">{{ __('Posts of') }} {{ $user->username }}</h5>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse ($posts as $post)
                        <li class="list-group-item">
                            <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a> <br>
                            <span class="small">{{ __('created') }} {{ $post->created_at }}</span> |
                            <span class="small">{{ $post->uploads->count() }} {{ __('uploaded files') }}</span>
                        </li>
                    @empty
                        <p>{{ __('No Posts.') }}</p>
                    @endforelse
                </ul>
            </div>
            <div class="card-footer">
                @if ($posts->isNotEmpty())
                    {{ $posts->firstItem()}} - {{ $posts->lastItem() }} {{ __('from') }} {{ $posts->total() }}
                    {{ $posts->links() }}
                @endif
            </div>
        </div>
        <div class="card my-4">
            <h5 class="card-header">{{ __('Replies of') }} {{ $user->username }}</h5>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse ($replies as $reply)
                        <li class="list-group-item">
                            <a href="{{ route('posts.show', $reply->post_id) }}">{{ str_limit($reply->content, 100) }}</a> <br>
                            <span class="small">{{ __('created') }} {{ $reply->created_at }}</span>
                        </li>
                    @empty
                        <p>{{ __('No Replies.') }}</p>
                    @endforelse
                </ul>
            </div>
            <div class="card-footer">
                @if ($replies->isNotEmpty())
                    {{ $replies->firstItem()}} - {{ $replies->lastItem() }} {{ __('from') }} {{ $replies->total() }}
                    {{ $replies->links() }}
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.app')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.show', $user->id) }}">{{ $user->username }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Edit profile') }}</li>
    </ol>
</nav>

<form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h1>{{ __('Edit Your Profile') }}</h1>
                    </div>
                    <div class="card-body">
                        <div class="form-group p-2">
                            <label>{{ __('Name') }}</label>
                            <input type="text" value="{{ old('name', $user->name) }}" class="form-control" name="name"
                                placeholder="Name"/>
                        </div>

                        <div class="form-group p-2">
                            <label>{{ __('Username') }}</label>
                            <input type="text" value="{{ old('username', $user->username) }}" class="form-control" name="username"
                                placeholder="Username"/>
                        </div>

                        <div class="form-group p-2">
                            <label>{{ __('E-Mail') }}</label>
                            <input type="email" value="{{ old('email', $user->email) }}" class="form-control" name="email"
                                placeholder="E-Mail"/>
                        </div>

                        <div class="form-group p-2">
                            <label>{{ __('Password') }}</label>
                            <input type="password"
                                class="form-control" name="password"/>
                        </div>

                        <div class="form-group p-2">
                            <label>{{ __('Confirm Password') }}</label>
                            <input type="password" class="form-control"
                                name="password_confirmation"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h1>{{ __('Change profile picture') }}</h1>
                    </div>
                    <div class="card-body">
                        <div class="form-group p-2">
                            <div class="mb-4">
                                @if ($user->avatar)
                                    <img src="{{ asset('storage/'.$user->avatar) }}" width="300px" alt="Avatar of {{ $user->username }}">
                                @else
                                    <img src="{{ asset('icons/blank-profile-picture.png') }}" width="300px" alt="Blank Avatar">
                                @endif
                            </div>
                            <input type="file" name="avatar">
                            @error('avatar')
                            <p class="text-danger mt-1">{{ $message}}</p>
                            @enderror
                        </div>

                        <div class="form-group p-2">
                            <a href="{{ route('users.reset_avatar', $user) }}" class="btn">{{ __('Reset profile picture?') }}</a>
                        </div>

                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h1>{{ __('Profile settings') }}</h1>
                    </div>
                    <div class="card-body">
                        <div class="form-group p-2">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="replyEmailSwitch" name="reply_email_notification" {{ $user->reply_email_notification == 1 ? 'checked' : '' }} />
                                <label class="custom-control-label" for="replyEmailSwitch">{{ __('Send me an E-Mail-Notification when someone replies to my post') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-lg mb-4" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};" >{{ __('Save Profile') }}</button>
            </div>
        </div>
    </form>

@endsection

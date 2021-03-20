@extends('layouts.app')

@section('content')

        <h1>User Profile</h1>
        <div>{{ $user->name }}</div>
        <div>{{ $user->username }}</div>
        <div>{{ $user->email }}</div>
        <div>
            @if ($user->avatar)
                <img src="{{ asset('storage/'.$user->avatar) }}" width="100px" alt="Avatar von  {{ $user->username }}">
            @else
                <img src="{{ asset('icons/blank-profile-picture.png') }}" width="100px" alt="Avatar von  {{ $user->username }}">
            @endif
        </div>
        
        @auth
            @if(auth()->user()->id == $user->id)
            <div>
                <a href="{{ route('users.reset_avatar', $user) }}" type="button" class="btn btn-danger btn-block m-0 mb-4 py-2">Reset Avatar to Default Picture</a>
            </div>
                <div>
                    <a href="{{ route('users.edit', $user) }}" type="button" class="btn btn-dark btn-block m-0 mb-4 py-2">Edit Your Profile</a>
                </div>
            @endif
        @endauth

@endsection
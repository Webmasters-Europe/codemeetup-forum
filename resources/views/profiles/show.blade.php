@extends('layouts.app')

@section('content')

        <h1>User Profile</h1>
        <div>{{ $user->name }}</div>
        <div>{{ $user->username }}</div>
        <div>{{ $user->email }}</div>
        
        @auth
            @if(auth()->user()->id == $user->id)
                <div>
                    <a href="{{ route('users.edit', $user) }}" type="button" class="btn btn-dark btn-block m-0 mb-4 py-2">Edit Your Profile</a>
                </div>
            @endif
        @endauth

@endsection
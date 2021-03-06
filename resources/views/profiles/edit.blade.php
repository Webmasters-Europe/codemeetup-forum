@extends('layouts.app')

@section('content')

<h1>Edit Your Profile</h1>

<form action="{{ route('users.update', $user) }}" method="POST" class="w-50">
    @csrf
    @method('PUT')

    <div class="form-group p-2">
      <label for="name">Name</label>
      <input type="text" value="{{ old('name', $user->name) }}" class="form-control" name="name" placeholder="Name" >
    </div>

    <div class="form-group p-2">
        <label for="name">Username</label>
        <input type="text" value="{{ old('username', $user->username) }}" class="form-control" name="username" placeholder="Username" >
      </div>

      <div class="form-group p-2">
        <label for="name">E-Mail</label>
        <input type="email" value="{{ old('email', $user->email) }}" class="form-control" name="email" placeholder="E-Mail" >
      </div>

    <button type="submit" class="btn btn-dark btn-lg ml-2">Save Profile</button>  
</form>      

@endsection
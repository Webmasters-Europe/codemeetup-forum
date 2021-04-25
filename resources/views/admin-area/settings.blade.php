@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin-area.dashboard') }}">Admin Area</a></li>
            <li class="breadcrumb-item active" aria-current="page">Settings</li>
        </ol>
    </nav>

    <h1>Settings</h1>

    <form>
        <div class="form-row">
          <div class="col">
            <label for="forum_name">Forum Name</label>
            <input type="text" class="form-control" name="forum_name" value="{{ old('forum_name') }}">
          </div>
          <div class="col">
            <label for="primary_color">Primary Color (in hex-code)</label>
            <input type="text" class="form-control" name="primary_color" value="{{ old('primary_color') }}">
          </div>
        </div>
      </form>

@endsection
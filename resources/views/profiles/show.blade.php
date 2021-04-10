@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-4">
        <div id="profile-card" class="card">
            @if ($user->avatar)
                <img class="card-img-top pt-4 px-4 pb-0" src="{{ asset('storage/'.$user->avatar) }}" width="100px" alt="Avatar von  {{ $user->username }}">
            @else
                <img class="card-img-top p-4" src="{{ asset('icons/blank-profile-picture.png') }}" width="100px" alt="Avatar von  {{ $user->username }}">
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $user->username }}</h5>
                <p class="card-text">E-mail: {{ $user->email }} </p>
                <p class="card-text">Name: {{ $user->name }} </p>
                @can('edit own profile')
                    @if(auth()->user()->id == $user->id)
                    <div>
                        <a href="{{ route('users.reset_avatar', $user) }}" >Reset Avatar to Default Picture</a>
                    </div>
                        <div>
                            <a href="{{ route('users.edit', $user) }}" type="button" class="btn btn-dark btn-block m-0 mt-4">Edit Your Profile</a>
                        </div>
                    @endif
                @endcan
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <h5 class="card-header">Last posts of {{ $user->username }}</h5>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Purus faucibus ornare suspendisse sed nisi lacus sed viverra tellus. Viverra maecenas accumsan lacus vel. Placerat duis ultricies lacus sed turpis tincidunt id aliquet. </li>
                    <li class="list-group-item">Condimentum lacinia quis vel eros donec ac odio tempor orci. Suscipit adipiscing bibendum est ultricies. Mattis pellentesque id nibh tortor. Faucibus interdum posuere lorem ipsum dolor sit amet consectetur adipiscing. Maecenas accumsan lacus vel facilisis volutpat est velit egestas dui. </li>
                    <li class="list-group-item">Mattis molestie a iaculis at erat pellentesque adipiscing commodo elit. Vitae tortor condimentum lacinia quis vel eros donec. Quisque sagittis purus sit amet volutpat consequat. Nulla malesuada pellentesque elit eget gravida cum. Egestas quis ipsum suspendisse ultrices. </li>
                </ul>
            </div>
        </div>
        <div class="card my-4">
            <h5 class="card-header">Last replies of {{ $user->username }}</h5>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Pellentesque nec nam aliquam sem et tortor. Risus ultricies tristique nulla aliquet. Nisl suscipit adipiscing bibendum est ultricies integer.</li>
                    <li class="list-group-item">Facilisis sed odio morbi quis commodo odio aenean sed adipiscing. Eu ultrices vitae auctor eu augue ut lectus arcu bibendum. Neque ornare aenean euismod elementum nisi quis eleifend quam. Neque vitae tempus quam pellentesque. Eget mi proin sed libero enim sed. Sagittis aliquam malesuada bibendum arcu vitae elementum. Euismod in pellentesque massa placerat duis ultricies.</li>
                    <li class="list-group-item">Iaculis at erat pellentesque adipiscing. Massa vitae tortor condimentum lacinia quis. Adipiscing diam donec adipiscing tristique risus nec feugiat in fermentum. Pharetra diam sit amet nisl. Egestas maecenas pharetra convallis posuere morbi leo urna molestie. Ut placerat orci nulla pellentesque dignissim enim sit.</li>
                </ul>
            </div>
        </div>
    </div>    
</div>

@endsection

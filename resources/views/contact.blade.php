@extends('layouts.app')

@section('content')

        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Contact') }}</li>
        </ol>
        </nav>
        <form action="{{ route('sendmail')}}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">{{ __('Contact') }}</h1>
                    <div class="card-text">
                        <div class="form-group d-flex flex-column">
                            <label for="name">{{ __('Name') }}</label>
                            <input id="name" type="text" value="{{ old('name') }}" class="form-control border" name="name"
                                placeholder="{{ __('Your name') }}"/>
                        </div>
                        <div class="form-group d-flex flex-column">
                            <label for="email">{{ __('E-Mail') }}</label>
                            <input id="email" type="email" value="{{ old('email') }}" class="form-control border" name="email"
                                placeholder="{{ __('Your E-Mail') }}"/>
                        </div>
                        <div class="form-group d-flex flex-column">
                            <label for="message">{{ __('Message') }}</label>
                            <textarea name="message" id="message" cols="100" rows="10" class="border" placeholder="{{ __('Your message') }}">{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-lg m-0 mb-2 py-2" >{{ __('Send Message') }}</button>
                    </div>
                </div>
            </div>        
        </form>

@endsection
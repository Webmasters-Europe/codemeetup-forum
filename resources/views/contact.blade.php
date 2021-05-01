@extends('layouts.app')

@section('content')

        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contact</li>
        </ol>
        </nav>
        <form action="{{ route('sendmail')}}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">Contact</h1>
                    <div class="card-text">
                        <div class="form-group p-2">
                            <label>Name</label>
                            <input type="text" value="{{ old('name') }}" class="form-control" name="name"
                                placeholder="Name"/>
                        </div>
                        <div class="form-group p-2">
                            <label>E-Mail</label>
                            <input type="email" value="{{ old('email') }}" class="form-control" name="email"
                                placeholder="E-Mail"/>
                        </div>
                        <div class="form-group p-2">
                            <h6>Message</h6>
       
                            <textarea name="message" id="message" cols="100" rows="10">{{ old('message') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
                <button type="submit" class="btn btn-lg mb-2 mt-2" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};" >Send Message</button>
        </form>

@endsection
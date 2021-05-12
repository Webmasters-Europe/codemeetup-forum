@extends('layouts.app')

@section('content')

        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Imprint') }}</li>
        </ol>
        </nav>

        <div class="card">
            <div class="card-body">
                <h1 class="card-title">{{ __('Imprint') }}</h1>
                
                <div class="card-text">
                    @php
                        $imprint = config('app.settings.imprint_page');
                    @endphp
                    @markdown($imprint)
                </div>
            </div>
        </div>

@endsection

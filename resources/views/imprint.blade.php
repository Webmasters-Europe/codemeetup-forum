@extends('layouts.app')

@section('content')

        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Imprint</li>
        </ol>
        </nav>

        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Imprint</h1>
                
                <div class="card-text">
                    @php
                        $imprint = config('app.settings.imprint_page');
                    @endphp
                    @markdown($imprint)
                </div>
            </div>
        </div>

@endsection

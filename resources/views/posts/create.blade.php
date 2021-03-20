@extends('layouts.app')
 <!-- @push('styles')
    <style>
        @media screen and (max-width:992px ){
            .w-50 {
                width: 100%!important;
            }
        }
    </style>
@endpush -->

@section('content')

          @livewire('create-post')

@endsection

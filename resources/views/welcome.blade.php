@extends('layouts.app')

@section('content')
            {{-- left container --}}
            <div class="lg:w-3/4 mb-2 md:w-3/4">
              @include('components.categoriesList')
            </div>

            {{-- right container --}}
            <div class="lg:w-1/4 md:w-1/4 md:pl-6 left:0">  
                <livewire:last-posts/>
            </div>
@endsection

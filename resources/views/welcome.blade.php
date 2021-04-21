@extends('layouts.app')

@section('content')
            {{-- left container --}}
            <div class="xl:w-3/4 sm:w-full mb-2">
              @include('components.categoriesList')
            </div>

            {{-- right container --}}
            <div class="w-1/4 pl-6 hidden xl:block">  
                <livewire:last-posts/>
            </div>
@endsection

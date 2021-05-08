<!doctype html>
<html  class="h-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <x-laravel-blade-sortable::scripts/>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="{{ asset('js/toggleLoginRegistration.js') }}"></script>

        <!-- Styles -->
        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ route('css') }}" type="text/css" rel="stylesheet" media="all">


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;700&display=swap" rel="stylesheet">


        @stack('styles')
        @livewireStyles
        @bukStyles(true)
    </head>
    <body>
        <div id="app"  class="h-100">
            <x-header><livewire:search-posts /></x-header>
            <div class="content-wrap container-fluid m-0 px-0 pt-0 h-100">
                <div class="row d-flex flex-lg-row-reverse no-gutters h-100">
                    <x-sidebar></x-sidebar>
                    <div class="col-lg-9 px-4">
                        <x-status></x-status>
                        <x-errors></x-errors>
                        @yield('content')
                    </div>
                </div>
            </div>
            <x-footer></x-footer>
        </div>
        @livewireScripts
        @livewireChartsScripts
        @bukScripts(true)
        @stack('scripts')
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    </body>
</html>

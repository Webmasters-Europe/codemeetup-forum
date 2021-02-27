<!doctype html>
<html  class="h-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- Styles -->

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                font-family: 'Nunito Sans', sans-serif;
            }

            h1 {
                font-size: 1.2rem;
                font-weight: 700;
            }

            .navbar-brand {
                font-size: 2rem;
                font-weight: 700;
            }
            @stack('styles')
        </style>
    </head>
    <body class="h-100">
        <div id="app"  class="h-100">
            <x-header></x-header>
            <div class="container-fluid m-0 p-0 h-100">
                <div class="row d-flex flex-lg-row-reverse no-gutters h-100">
                    <x-sidebar></x-sidebar>
                    <x-status></x-status>
                    <x-errors></x-errors>
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Forum</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
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

    </style>

</head>

<body style=";">
    <div class="container-fluid">
        <nav class="navbar navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand">Forum</a>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </nav>
        <div class="container-fluid">
            @auth
            <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
            @else
            <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
            @endif
            @endauth
        </div>
        <div class="container-fluid">
            <div id="section1" class="row row-cols-4">
                <div class="col-3 col-lg-2">
                    <img src="https://picsum.photos/60" alt="image">
                </div>
                <div class="col-6 col-lg-4">
                    <h1>Section name</h1>
                </div>
                <div class="col-3 col-lg-2">7</div>
                <div class="col-12 col-lg-4">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. </p>
                </div>
            </div>
            <div id="section2" class="row row-cols-4">
                <div class="col-3 col-lg-2">
                    <img src="https://picsum.photos/60" alt="image">
                </div>
                <div class="col-6 col-lg-4">
                    <h1>Section name</h1>
                </div>
                <div class="col-3 col-lg-2">7</div>
                <div class="col-12 col-lg-4">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. </p>
                </div>
            </div>
            <div id="section1" class="row row-cols-4">
                <div class="col-3 col-lg-2">
                    <img src="https://picsum.photos/60" alt="image">
                </div>
                <div class="col-6 col-lg-4">
                    <h1>Section name</h1>
                </div>
                <div class="col-3 col-lg-2">7</div>
                <div class="col-12 col-lg-4">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. </p>
                </div>
            </div>
            <div id="section1" class="row row-cols-4">
                <div class="col-3 col-lg-2">
                    <img src="https://picsum.photos/60" alt="image">
                </div>
                <div class="col-6 col-lg-4">
                    <h1>Section name</h1>
                </div>
                <div class="col-3 col-lg-2">7</div>
                <div class="col-12 col-lg-4">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. </p>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>

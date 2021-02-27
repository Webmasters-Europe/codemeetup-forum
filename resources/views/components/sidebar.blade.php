<div class="col-lg-2 border my-2 py-2">
    @auth
    <a href="{{ url('/') }}" class="text-sm text-gray-700 underline">Home</a>
    @else
    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

    @if (Route::has('register'))
    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
    @endif
    @endauth
</div>
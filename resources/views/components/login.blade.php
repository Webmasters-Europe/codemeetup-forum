@extends('layouts.app')

@section('content')

<div class="container mx-auto p-8 flex">
    <div class="max-w-md w-full mx-auto">
        <div class="bg-white rounded-lg overflow-hidden shadow-2xl">
            <div class="p-8">
                <form id="login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-5">
                        <input id="login" type="text" class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none"
                        name="login" placeholder='Username or E-Mail' required autocomplete="login" autofocus>
                    </div>

                    <div class="mb-5">
                        <input id="password-login" type="password"
                        class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none"
                        minlength="8"
                        name="password" placeholder='Password' required autocomplete="current-password">
                    </div>
                    
                    <button type="submit" class="w-full p-3 mt-4 bg-indigo-600 text-white rounded shadow">Login</button>

                    <input class="mt-4" type="checkbox" name="remember" id="remember" {{ old('login-form') && old('remember') ? 'checked' : '' }}>
                    <label class="text-gray-600 text-sm mt-4" for="remember">
                        {{ __('Remember Me') }}
                    </label>

                    <!-- oAuth -->
                    <div class="flex justify-between mt-4 text-sm">
                        <a href="{{ route('oauth', ['provider' => 'google']) }}">
                            <img src="{{ asset('icons/google.png') }}" alt="google-icon"> Login with Google
                        </a>
                        <a href="{{ route('oauth', ['provider' => 'github']) }}">
                            <img src="{{ asset('icons/github.png') }}" alt="github-icon"> Login with Github
                        </a>
                    </div>

                </form>
            </div>
            
            <div class="flex justify-between p-8 text-sm border-t border-gray-300 bg-gray-100">
                <a href="{{ route('register') }}" class="font-medium text-indigo-500">Create account</a>
                
                @if (Route::has('password.request'))
                    <a class="text-gray-600" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>



@endsection
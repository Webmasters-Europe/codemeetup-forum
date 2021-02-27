<div class="col-lg-3 border my-2 py-2">
       
    @auth
    <a href="{{ url('/') }}" class="text-sm text-gray-700 underline">Home</a>
    <a href="{{ route('posts.create') }}">Create Post</a>
    @else
    <div>

        <x-errors/>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group row m-0 p-2">
                
                    <input id="login" type="text" class="form-control @error('username') is-invalid @enderror" name="login" value="{{ old('login') }}" placeholder='Username or E-Mail' required autocomplete="login" autofocus>

                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                
            </div>

            <div class="form-group row m-0 p-2">

                
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder='Password' required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                
            </div>

            <div class="form-group row m-0 p-2">

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
 
            </div>

            <div class="form-group row m-0 p-2">

                    <button type="submit" class="btn btn-lg btn-block btn-dark">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                
            </div>
        </form>
            <a class="btn btn-block btn-outline-dark my-2 p-2" href="auth/google"><img src="{{ asset('icons/google.png') }}" alt="google-icon"> Login with Google</a> 
            <a class="btn btn-block btn-outline-dark my-2 p-2" href="auth/github"><img src="{{ asset('icons/github.png') }}" alt="github-icon"> Login with Github</a> 
    </div>

    @if (Route::has('register'))
    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">I'm not registered yet</a>
    @endif
    @endauth
    
</div>

<div class="col-lg-3 my-2 px-4">
    <div id="sidebar" class="d-lg-block collapse">
        @can('edit own profile')

        <div id="user-profile" class="d-flex justify-content-start mb-4 py-2">
        @if (auth()->user()->avatar)
            <img src="{{ asset('storage/'.auth()->user()->avatar) }}" width="100px" alt="Avatar von  {{ auth()->user()->username }}">
        @else
            <img src="{{ asset('icons/blank-profile-picture.png') }}" width="100px" alt="Avatar von  {{ auth()->user()->username }}">
        @endif
            <div class="ml-4" id="user-profile-text">
                <h5>Name: <strong>{{ auth()->user()->name }}</strong></h5>
                <h5>Username: <strong>{{ auth()->user()->username }}</strong></h5>
            </div>
        </div>

        <a href="{{ route('users.show', auth()->user() ) }}" type="button" class="btn btn-dark btn-block m-0 mb-4 py-2">Profile</a>

        @can('access admin area')
            <a href="{{ route('admin-area.dashboard') }}" type="button" class="btn btn-primary btn-block m-0 mb-4 py-2">Admin Area</a>
        @endcan

        <form action="{{ route('logout') }}" method="POST" class="w-100">
            @csrf

            <button type="submit" class="btn btn-dark btn-lg btn-block">Logout</button>

        </form>

            @else
                <div>

                    <!-- Login form -->

                    <form id="login-form" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row m-0 py-2">

                            <input id="login" type="text" class="form-control @error('username') is-invalid @enderror"
                                name="login" value="{{ old('login') }}" placeholder='Username or E-Mail' required
                                autocomplete="login" autofocus>

                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group row m-0 py-2">

                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" placeholder='Password' required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group row m-0 py-2">

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember"
                                    id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="form-group row m-0 mb-4 py-2">

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

                    <!-- Registration form -->

                    <form hidden id="reg-form" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row m-0 py-2">

                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Your name" name="name" value="{{ old('name') }}" required autocomplete="name"
                                autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                        <div class="form-group row m-0 py-2">

                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                                placeholder="Username" name="username" value="{{ old('username') }}" required
                                autocomplete="username" autofocus>

                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                        <div class="form-group row m-0 py-2">

                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="E-Mail" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                        <div class="form-group row m-0 py-2">

                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="Password" name="password" required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                        <div class="form-group row m-0 py-2">

                            <input id="password-confirm" type="password" class="form-control"
                                placeholder="Confirm your password" name="password_confirmation" required
                                autocomplete="new-password">

                        </div>

                        <div class="form-group row m-0 mb-4 py-2">

                            <button type="submit" class="btn btn-lg btn-block btn-dark">
                                {{ __('Register') }}
                            </button>

                        </div>
                    </form>

                    <!-- oAuth -->

                    <a class="btn btn-block btn-outline-dark my-2 p-2"
                    href="{{ route('oauth', ['provider' => 'google']) }}"><img src="{{ asset('icons/google.png') }}"
                                                                                alt="google-icon"> Login with Google</a>
                    <a class="btn btn-block btn-outline-dark my-2 p-2"
                    href="{{ route('oauth', ['provider' => 'github']) }}"><img src="{{ asset('icons/github.png') }}"
                                                                                alt="github-icon"> Login with Github</a>

                </div>

            <a id="to-registration" onclick="toggleLoginRegistration()" class="ml-4 text-sm text-gray-700 underline">I'm not registered yet</a>
            <a hidden id="to-login" onclick="toggleLoginRegistration()" class="ml-4 text-sm text-gray-700 underline">I'm already registered</a>


            @endcan
            <livewire:last-posts />

    </div>
</div>

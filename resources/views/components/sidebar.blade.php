<div class="col-lg-3 my-2 px-4">
    <div id="sidebar" class="d-lg-block collapse">
        @can('edit own profile')

            <div id="user-profile" class="d-flex justify-content-start mb-4 py-2">
                @if (auth()->user()->avatar)
                    <img src="{{ asset('storage/'.auth()->user()->avatar) }}" width="100px"
                         alt="Avatar von  {{ auth()->user()->username }}">
                @else
                    <img src="{{ asset('icons/blank-profile-picture.png') }}" width="100px"
                         alt="Avatar von  {{ auth()->user()->username }}">
                @endif
                <div class="ml-4" id="user-profile-text">
                    <h5>{{ __('Name') }}: <strong>{{ auth()->user()->name }}</strong></h5>
                    <h5>{{ __('Username') }}: <strong>{{ auth()->user()->username }}</strong></h5>
                    <h5>{{ __('Unread Notifications') }}: <a href="{{ route('users.show', auth()->user() ) }}" class="badge text-white">{{ auth()->user()->unreadNotifications->count() }}</a></h5>
                </div>
            </div>

            <a href="{{ route('users.show', auth()->user() ) }}" type="button"
               class="btn btn-block m-0 mb-2 py-2">{{ __('Profile') }}</a>

            @can('access admin area')
                <a href="{{ route('admin-area.dashboard') }}" type="button"
                   class="btn btn-block m-0 mb-2 py-2" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};">{{ __('Admin Area') }}</a>
            @endcan

            <form action="{{ route('logout') }}" method="POST" class="w-100">
                @csrf

                <button type="submit" class="btn btn-block m-0 mb-2 py-2" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};"><i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}</button>

            </form>

        @else
            <div>

                <!-- Login form -->
                <form {{ count($errors) > 0 && old('reg-form') ? "hidden" : "" }} id="login-form" method="POST" action="{{ route('login') }}">
                    @csrf

                    <input type="hidden" name="login-form" value="1">

                    <div class="form-group row m-0 py-2">

                        <input id="login" type="text" class="form-control @error('username') {{ old('login-form') ? "is-invalid" : ""}} @enderror"
                               name="login" value="{{ old('login-form') ? old('login') : ""}}" placeholder='{{ __('Username or E-Mail') }}' required
                               autocomplete="login" autofocus>

                        @if(old('login-form'))
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        @endif
                    </div>

                    <div class="form-group row m-0 py-2">

                        <input id="password-login" type="password"
                               class="form-control @error('password') {{ old('login-form') ? "is-invalid" : ""}} @enderror"
                               minlength="8"
                               name="password" placeholder='{{ __('Password') }}' required autocomplete="current-password">

                        @if(old('login-form'))
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        @endif
                    </div>

                    <div class="form-group row m-0 py-2">

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember"
                                   id="remember" {{ old('login-form') && old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group row m-0 mb-4 py-2">

                        <button type="submit" class="btn btn-lg btn-block btn-dark m-0 mb-2 py-2">
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif

                    </div>
                </form>

                <!-- Registration form -->
                <form {{ count($errors) === 0 || $errors && old('login-form') ? "hidden" : "" }} id="reg-form" method="POST" action="{{ route('register') }}">
                    @csrf

                    <input type="hidden" name="reg-form" value="1">

                    <div class="form-group row m-0 py-2">

                        <input id="name" type="text" class="form-control @error('name') {{ old('reg-form') ? "is-invalid" : ""}} @enderror"
                               placeholder="{{ __('Your name') }}" name="name" value="{{ old('reg-form') ? old('name') : "" }}" required
                               autocomplete="name"
                               autofocus>

                        @if(old('reg-form'))
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        @endif

                    </div>

                    <div class="form-group row m-0 py-2">

                        <input id="username" type="text" class="form-control @error('username') {{ old('reg-form') ? "is-invalid" : ""}} @enderror"
                               placeholder="{{ __('Username') }}" name="username" value="{{ old('reg-form') ? old('username') : "" }}" required
                               autocomplete="username" autofocus>

                        @if(old('reg-form'))
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        @endif
                    </div>

                    <div class="form-group row m-0 py-2">

                        <input id="email" type="email" class="form-control @error('email') {{ old('reg-form') ? "is-invalid" : ""}} @enderror"
                               placeholder="{{ __('E-Mail') }}" name="email" value="{{ old('reg-form') ? old('email') : "" }}" required
                               autocomplete="email">

                        @if(old('reg-form'))
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        @endif
                    </div>

                    <div class="form-group row m-0 py-2">

                        <input id="password-registration" type="password"
                               class="form-control @error('password') {{ old('reg-form') ? "is-invalid" : ""}} @enderror"
                               minlength="8"
                               placeholder="{{ __('Password') }}" name="password" required autocomplete="new-password">

                        @if(old('reg-form'))
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        @endif
                    </div>

                    <div class="form-group row m-0 py-2">

                        <input id="password-confirm" type="password" class="form-control"
                               minlength="8"
                               placeholder="{{ __('Confirm your password') }}" name="password_confirmation" required
                               autocomplete="new-password">

                    </div>

                    <div class="form-group row m-0 mb-4 py-2">

                        <button type="submit" class="btn btn-lg btn-block btn-dark m-0 mb-2 py-2">
                            {{ __('Register') }}
                        </button>

                    </div>
                </form>

                <!-- oAuth -->

                <a class="btn btn-block btn-outline-dark outline-primary m-0 mb-2 py-2"
                   href="{{ route('oauth', ['provider' => 'google']) }}"><img src="{{ asset('icons/google.png') }}"
                                                                              alt="google-icon"> {{ __('Login with Google') }}</a>
                <a class="btn btn-block btn-outline-dark outline-primary m-0 mb-2 py-2"
                   href="{{ route('oauth', ['provider' => 'github']) }}"><img src="{{ asset('icons/github.png') }}"
                                                                              alt="github-icon"> {{ __('Login with Github') }}</a>

            </div>

            <a {{ count($errors) > 0 && old('reg-form') ? "hidden" : "" }} id="to-registration" onclick="toggleLoginRegistration()">
                {{ __('I am not registered yet.') }}</a>
            <a {{ count($errors) === 0 || $errors && old('login-form') ? "hidden" : "" }} id="to-login" onclick="toggleLoginRegistration()">
                {{__('I am already registered.') }}</a>


        @endcan
        <livewire:last-posts/>

    </div>
</div>

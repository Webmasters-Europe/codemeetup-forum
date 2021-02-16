<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use App\Models\SocialAuth;
use Laravel\Socialite\Facades\Socialite;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Save username in variable
     *
     * @var string
     */
    protected $login;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->login = $this->findLoginFieldType();
    }

    /**
     * Get username
     *
     * @return string
     */
    public function findLoginFieldType() {
        $login = request()->input('login');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $login]);
        return $fieldType;
    }

    /**
     * Get username property
     *
     * @return string
     */
    public function username() {
        return $this->login;
    }


    public function redirectToProvider($provider) {
        return Socialite::driver($provider)->redirect();
    }


    public function handleProviderCallback($provider) {
        try {
            $oauthUser = Socialite::driver($provider)->user();
        } catch (Exception $exeption) {
            return redirect('/login');
        }
        $oauthUser = $this->findOrCreateUser($oauthUser, $provider);
        auth()->login($oauthUser, true);
        return redirect($this->redirectTo);
    }

    
    public function findOrCreateUser($oauthuser, $provider) {
        $existingOAuth = SocialAuth::where('provider_name', $provider)
            ->where('provider_id', $oauthuser->getId())
            ->first();
        if ($existingOAuth) {
            return $existingOAuth->user;
        } else {
            $user = User::whereEmail($oauthuser->getEmail())->first();
            if (!$user) {
                $user = User::create([
                    'name' => $oauthuser->getName() ?? $oauthuser->getNickname() ?? '',
                    'username' => $oauthuser->getNickname() ?? $oauthuser->getName() ?? '',
                    'email' => $oauthuser->getEmail(),
                ]);
            }
            $user->socialAuths()->create([
                'provider_name' => $provider,
                'provider_id' => $oauthuser->getId(),
            ]); 
            return $user;
        }
    }

}

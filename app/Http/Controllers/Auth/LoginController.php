<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
    }

    /**
     * Get username
     *
     * @return string
     */
    public function findUsername() {
        /* get input from request */
        $login = request()->input('username');
        /* check, if input is an valid email
        if true -> field type = email, if false field type = username */
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        /* add fieldType with login to request */
        request()->merge([$fieldType => $login]);
        /* return fieldtype (email or username) */
        return $fieldType;
    }

    /**
     * Get username property
     *
     * @return string
     */
    public function username() {
        return $this->username;
    }


}

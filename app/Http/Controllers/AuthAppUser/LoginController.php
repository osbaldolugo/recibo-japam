<?php

namespace App\Http\Controllers\AuthAppUser;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Flash;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        return view('auth-app-user.login');
    }

    public function register() {
        return view('auth-app-user.register');
    }

    public function postLogin(Request $request)
    {

        if (Auth::guard('appuser')->attempt(['email' => $request["email"], "activated" => 1, "password" => $request["password"]])) {
            return redirect(route('receipts.indexWeb'));
        } else {
            return $this->sendFailedLoginResponse($request);
        }

    }

    public function logout()
    {
        Auth::guard('appuser')->logout();
        session()->flush();
        return redirect(route('appUser.login'));
    }
}

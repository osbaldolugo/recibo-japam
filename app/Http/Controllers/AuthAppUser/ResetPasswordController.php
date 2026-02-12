<?php

namespace App\Http\Controllers\AuthAppUser;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Password;
use Auth;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/receipts';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:appuser');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords_app_user.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    protected function guard(){
        return Auth::guard('appuser');
    }

    protected function broker(){
        return Password::broker('appuser');
    }
}

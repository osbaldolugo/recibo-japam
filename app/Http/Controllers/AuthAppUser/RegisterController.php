<?php

namespace App\Http\Controllers\AuthAppUser;

use DB;
use Session;
use App\Models\People;
use App\Models\AppUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AppUserController;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }


    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'lastnames' => 'required',
            'phoneNumber' => 'required',
            'email' => 'required|email|unique:app_user,email',
            'password' => 'required|min:6|confirmed'
        ],[
            'email.unique' => 'El correo electrónico ya existe.'
        ]);

        try
        {
            DB::beginTransaction();
            $lastnames = explode(" ", $request['lastnames']);

            $requestPeople = [
                'name' => $request['name'],
                'last_name_1' => isset($lastnames[0])?$lastnames[0]:null,
                'last_name_2' => isset($lastnames[1])?$lastnames[1]:null
            ];

            $people = People::updateOrCreate($requestPeople,$requestPeople);

            $appUser = AppUser::create([
                'people_id' => $people->id,
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'phone_number' => str_replace("-", "", $request['phoneNumber']),
                'acceptChallenge' => isset($request['challenge']) ? true:  null,
                'activated' => 0,
            ]);

            $token = AppUser::generateToken();
            $appUser->verify_token = $token;
            $appUser->save();

            DB::commit();

            AppUserController::sendEmail($people->name.' '.$people->last_name_1, $appUser->email, $appUser->verify_token);


            Session::flash('success','Te hemos enviado un correo electrónico a tu cuenta, abre tu correo y activa tu cuenta para poder iniciar sesión');
            return redirect()->route('appUser.login.view');
        }
        catch(Exeption $ex)
        {
            DB::rollback();
            Session::flash('error','Intente registrarse más tarde.');
            return redirect()->back()->withInput($request->all);
        }



    }
}

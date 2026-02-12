<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\AppUserController;
use DB;
use Route;
use App\User;
use App\Models\People;
use App\Models\AppUser;
use Laravel\Passport\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    private $client;

    /**
     * @param $client
     */
    public function __construct()
    {
        $this->client = Client::find(2);
    }


    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'lastnames' => 'required',
            'email' => 'required|email|unique:app_user,email',
            'password' => 'required|min:6|confirmed'
        ],[
            'email.unique' => 'El correo electrónico ya existe.'
        ]);

        $data = $request->all();

        try
        {
            DB::beginTransaction();
            $lastnames = explode(" ", $data['lastnames']);

            $requestPeople = [
                'name' => $data['name'],
                'last_name_1' => isset($lastnames[0])?$lastnames[0]:null,
                'last_name_2' => isset($lastnames[1])?$lastnames[1]:null
            ];

            $people = People::updateOrCreate($requestPeople,$requestPeople);

            $appUser = AppUser::create([
                'people_id' => $people->id,
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'phone_number' => $data['phoneNumber'],
                'acceptChallenge' => isset($request['challenge']) ? $request['challenge']:  null,
                'activated' => 0,
            ]);

            $token = AppUser::generateToken();
            $appUser->verify_token = $token;
            $appUser->save();

            DB::commit();

            AppUserController::sendEmail($people->name.' '.$people->last_name_1, $appUser->email, $appUser->verify_token);

            $params = [
                'grant_type' => 'password',
                'client_id' => $this->client->id,
                'client_secret' => $this->client->secret,
                'username' => $data['email'],
                'password' => $data['password'],
                'scope' => '*'
            ];

            return response()->json(['data' => $people], 200);
        }
        catch(Exeption $ex)
        {
            DB::rollback();
            return response()->json(['error' => 'Ocurrió un error al registrarse, inténtelo nuevamente.'], 422);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Agent;
use DB;
use Auth;
use Hash;
use App\Models\People;
use App\Models\AppUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{

    /**
     * UserController constructor.
     */
    public function __construct()
    {

    }


    /**
     * Return appuser information
     */
    public function index()
    {
        $appUser = Auth::user()->id;
        $agent = Agent::with("categories")->where("id",$appUser)->first()->toArray();
        return response()->json(['user' => $agent], 200);
    }


    public function recoverPassword(Request $request)
    {
        //Validar datos recibidos
        $this->validate($request, ['email'=>'required|email']);

        $email =  $request->input('email');
        $appUser = AppUser::where('email', '=', $email)->first();

        if(!$appUser){
            return response()->json(["error"=>"El correo electrónico no existe."], 422);
        }

        try {
            DB::beginTransaction();
            $password = str_random(8);
            $appUser->password = bcrypt($password);
            $appUser->save();

            $people = $appUser->people;

            AppUser::sendCredentials([
                "name" => $people->name.' '.$people->last_name_1.' '.$people->last_name_2,
                "email" => $appUser->email,
                "password" => $password
            ]);
            DB::commit();
            return response()->json(["msg" => "Su contraseña ha sido reestablecida, por favor revise su correo electrónico."], 200);
        } catch (\Swift_TransportException $e) {
            DB::rollBack();
            return response()->json(["error" => "Error al restaurar contraseña, intente más tarde"], 400);
        }
    }

    public function updateUser(Request $request)
    {
        $app_user = AppUser::find($request->input('id'));

        if (empty($app_user))
            return response()->json(['msg' => 'Usuario no encontrado'], 404);

        $people = People::find($app_user->people_id);

        try
        {
            $app_user->update([
                'email' => $request->input('email'),
                'phone_number' => $request->input('phoneNumber'),
                'correo' => $request->input('correo'),
            ]);

            $lastnames = explode(" ", $request->input('lastnames'));
            $people->update([
                'name' => $request->input('name'),
                'last_name_1' => isset($lastnames[0])?$lastnames[0]:null,
                'last_name_2' => isset($lastnames[1])?$lastnames[1]:null,
            ]);

            $userDetails = AppUser::where('id', '=', $app_user->id)->with('people')->first();

            DB::commit();
            return response()->json(['data' => $userDetails, 'msg' => 'Perfil actualizado correctamente.'], 200);

        } catch (Exeption $e)
        {
            DB::rollback();
            return response()->json(['msg' => 'Perfil no actualizado.'], 422);
        }
    }

    public function validateEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'unique:app_user,email,' . $request->input('id') .'',
        ]);

        $app_user = AppUser::where('email', '=', $request->input('email'))
            ->whereNotIn('id', [$request->input('id')])
            ->first();

        return response()->json(['data' => $app_user], 200);
    }

    public function validateIfExists(Request $request)
    {
        $this->validate($request, [
            'email' => 'unique:app_user,email',
        ]);

        return response()->json(['data' => true], 200);
    }

    public function updatePassword(Request $request)
    {
        $app_user = AppUser::where('id', '=', $request->input('id'))
            ->first();

        try
        {
            $app_user->update([
                'password' => bcrypt($request->input('password')),
            ]);

            DB::commit();
            return response()->json(['msg' => 'Contraseña actualizada correctamente.'], 200);

        } catch (Exeption $e)
        {
            DB::rollback();
            return response()->json(['msg' => 'Contraseña no actualizada.'], 422);
        }
    }

    public function validateOldPassword(Request $request)
    {
        $exists = false;
        $app_user = AppUser::where('id', '=', $request->input('id'))
            ->first();

        if (Hash::check($request->input('oldPassword'), $app_user->password)) {
            $exists = true;
        }

        return response()->json(['exists' => $exists], 200);
    }

    public function registerFirebaseToken(Request $request){
      $appUser = Auth::user();
      $appUser->firebase_token = $request->input('firebase_token');
      $appUser->save();

      return response()->json(['token' => $request->input('firebase_token')], 200);
    }
}

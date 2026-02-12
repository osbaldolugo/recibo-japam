<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\AppUserController;
use App\Models\AppUser;
use DB;
use Auth;
use Route;
use Laravel\Passport\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    private $client;

    /**
     * @param $client
     */
    public function __construct()
    {
        $this->client = Client::find(2);
    }


    public function login(Request $request){

        $request->merge(["provider" => "api"]);

        $this->validate($request, [
            'email'=> 'required',
            'password'=> 'required'
        ]);

        if (Auth::guard('appuser')->attempt(['email' => request('email'), 'password' => request('password')])) {
            if (Auth::guard('appuser')->user()->activated ==0)
                return response()->json(['activated' => false], 200);

            $params = [
                'grant_type' => 'password',
                'client_id' => $this->client->id,
                'client_secret' => $this->client->secret,
                'username' => request('email'),
                'password' => request('password'),
                'scope' => '*'
            ];

            $request->request->add($params);
            $proxy = Request::create('oauth/token', 'POST');

            return Route::dispatch($proxy);
        } else {
            return response()->json(['error' => 'Credenciales incorrectas.'], 422);
        }
    }

    public function refresh(Request $request){
        $this->validate($request, [
            'refresh_token' => 'required'
        ]);

        $params = [
            'grant_type' => 'refresh_token',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret
        ];
        
        $request->request->add($params);
        $proxy = Request::create('oauth/token', 'POST');
        return Route::dispatch($proxy);
    }

    public function logout(){
        $accessToken = Auth::user()->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update(['revoked' => true]);
        $accessToken->revoke();
        return response()->json([], 204);
    }
}
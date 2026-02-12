<?php

namespace App\Http\Controllers;

use App\DataTables\AppUserCardDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAppUserCardRequest;
use App\Http\Requests\UpdateAppUserCardRequest;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\AppUserCard;
use Auth;
use Illuminate\Database\QueryException;

class AppUserCardController extends AppBaseController
{

    public function __construct()
    {
    }

    public function index(AppUserCardDataTable $appUserCardDataTable)
    {
        return $appUserCardDataTable->render('user_panel.app_user_cards.index');
    }


    public function store(CreateAppUserCardRequest $request)
    {

        try {

            AppUserCard::firstOrCreate([
                'app_user_id' => Auth::guard('appuser')->user()->id,
                'owner' => $request["owner"],
                'number' => $request["number"],
                'exp_month' => $request["exp_month"],
                'exp_year' => $request["exp_year"]
            ]);

            return response()->json(["message" => "Tarjeta guardada correctamente"], 200);

        } catch (QueryException $e) {
            return response()->json(["message" => "Ocurrió un error al guardar la tarjeta, intente más tarde"], 500);
        }

    }

    public function delete($id)
    {
        $card = AppUserCard::find($id);
        if (empty($card))
            return response()->json(["message" => "No se encontró la tarjeta"], 404);

        $card->delete();

        return response()->json(["message" => "Tarjeta eliminada correctamente"], 200);

    }

    public function defaultCard($id)
    {
        $card = AppUserCard::find($id);
        if (empty($card))
            return response()->json(["message" => "No se encontró la tarjeta"], 404);


        $card->default = 1;
        $card->save();

        //Remove default tag on other app user cards
        AppUserCard::where('app_user_id', Auth::guard('appuser')->user()->id)
            ->whereNotIn('id', [$id])
            ->update(["default" => 0]);

        return response()->json(["message" => "Tarjeta marcada como predeterminada"], 200);
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Metrics;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Http\Controllers\AppBaseController;


class MetricsController extends AppBaseController
{
    public function store(Request $request){
        try{
            //dd($request);
            $metrics = new Metrics();
            $metrics->name = $request->input('name');
            $metrics->contract = $request->input('contractSave');
            $metrics->site = $request->input('site');
            $metrics->boton_type = $request->input('boton_type');
            $metrics->save();
            return response()->json(["msg" => "Abriendo enlace de pago."], 200);
        }catch (Exception $exception){
            return response()->json(array('msg' => $exception), 500);
        }

    }
}

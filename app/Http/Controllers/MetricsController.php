<?php

namespace App\Http\Controllers;

use App\Models\Metrics;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Flash;
use Response;
use DB;

class MetricsController extends Controller
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
    
     public function consultaDeFechas(Request $request){

        $from = $request->input('from4');
        $to = $request->input('to4');
       // dd($request);
       $to1 = $to.' '.'23:59:59';

        $consultaWeb = Metrics::where('site', "=", "web")
                            ->where("boton_type", "=", "ligaPago")
                            ->whereBetween("created_at", [$from, $to1])->count();

        $consultaApp = Metrics::where('site', "=", "app")
                            ->where("boton_type", "=", "ligaPago")
                            ->whereBetween("created_at", [$from, $to1])->count();

        $consulta = $consultaApp.','.$consultaWeb;

       // dd($consulta);
        return response()->json($consulta, 200);
    }

    public function consultaDeDescargas(Request $request){
        $from5 = $request->input('from5');
        $to5 = $request->input('to5');
        // dd($request);
        $to1 = $to5.' '.'23:59:59';

        $consultaWeb = Metrics::where('site', "=", "web")
            ->where("boton_type", "=", "generarPdf")
            ->whereBetween("created_at", [$from5, $to1])->count();

        $consultaApp = Metrics::where('site', "=", "app")
            ->where("boton_type", "=", "generarPdf")
            ->whereBetween("created_at", [$from5, $to1])->count();

        $consulta = $consultaApp.','.$consultaWeb;

        // dd($consulta);
        return response()->json($consulta, 200);
    }
}

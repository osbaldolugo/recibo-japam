<?php

namespace App\Http\Controllers;

use App\Models\AppTicket;
use App\Models\Metrics;
use App\Models\OnClick;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;


class OnClickController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    //Abstraccion de reportes para la gráfica
        $reporteApp = AppTicket::where([
            ['type', 'Reporte'],
            ['origen', 'app']
        ])->count();
        $reporteWeb = AppTicket::where([
            ['type', 'Reporte'],
            ['origen', 'web']
        ])->count();
        $totalReportes = $reporteApp . $reporteWeb;

    //Abstraccion de denuncias para la gráfica
        $denunciaApp = AppTicket::where([
            ['type', 'Denuncia'],
            ['origen', 'app']
        ])->count();
        $denunciaWeb = AppTicket::where([
           ['type', 'Denuncia'],
           ['origen', 'web']
        ])->count();
        $totalDenuncias = $denunciaApp . $denunciaWeb;

    //Abstraccion de quejas para la gráfica
        $quejaApp = Complaint::where([
            ['type', 'queja'],
            ['origen', 'app']
        ])->count();
        $quejaWeb = Complaint::where([
            ['type', 'queja'],
            ['origen', 'web']
        ])->count();
        $totalQuejas = $quejaApp . $quejaWeb;

        //Abstracción de pagos generados de web y app
        $enlacesWeb = Metrics::where([
            ['boton_type', 'ligaPago'],
            ['site', 'web']
        ])->count();
        $enlacesApp = Metrics::where([
            ['boton_type', 'ligaPago'],
            ['site', 'app']
        ])->count();
        $totalPagos = $enlacesWeb . $enlacesApp;

        //Abstraccion de generación de pdfs de web y app
        $pdfWeb = Metrics::where([
            ['boton_type', 'generarPdf'],
            ['site', 'web']
        ])->count();
        $pdfApp = Metrics::where([
            ['boton_type', 'generarPdf'],
            ['site', 'app']
        ])->count();
        $pdf = $pdfWeb . $pdfApp;

        //Abstracción de vistas a video
        $videoOpen = Metrics::where([
            ['boton_type', 'verVideo'],
            ['site', 'app']
        ])->count();

        //dd($total);
        return view('metrics.metrics', array(
            'totalReportes' => $totalReportes,
            'totalDenuncias' => $totalDenuncias,
            'totalQuejas' => $totalQuejas,
            'totalPagos' => $totalPagos,
            'pdf' => $pdf,
            'videoOpen' => $videoOpen
            ));
       //return [$datos, $data];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app_tickets.wordpressForm.crear');
    }
    public function create1()
    {
        return view('user_panel.receipts.azael');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $click = new OnClick();
            $click_consulta_web = $request->input('click_consulta_web');
            $click_consulta_app = $request->input('click_consulta_app');
            $click_pagolink_web = $request->input('click_pagolink_web');
            $click_pagolink_app = $request->input('click_pagolink_app');
            $click_pagolink_app = $request->input('click_pagolink_app');

            if ($click_consulta_web == 1){
                DB::table('onclick_counts')->where('id', '=', '1')->increment('click_consulta_web', '1');
            }elseif ($click_consulta_app == 1){
                DB::table('onclick_counts')->where('id', '=', '1')->increment('click_consulta_app', '1');
            }elseif ($click_pagolink_web == 1){
                DB::table('onclick_counts')->where('id', '=', '1')->increment('click_pagolink_web', '1');
            }elseif ($click_pagolink_app == 1){
                DB::table('onclick_counts')->where('id', '=', '1')->increment('click_pagolink_app', '1');
            }
            return back()->with('message', 'token efectuado correctamente');
        }catch (Exception $exception){
            return response()->json(array('msg' => $exception), 500);
        }

    }

    public function consultaDeFechas(Request $request){

        $from = $request->input('from1');
        $to = $request->input('to1');
        // dd($request);
        $to1 = $to.' '.'23:59:59';


        $consultaWeb = Complaint::where('origen', "=", "app")
            ->where("type", "=", "queja")
            ->whereBetween("created_at", [$from, $to1])->count();

        $consultaApp = Complaint::where('origen', "=", "web")
            ->where("type", "=", "queja")
            ->whereBetween("created_at", [$from, $to1])->count();

        $consulta = $consultaWeb.','.$consultaApp;

        // dd($consulta);
        return response()->json($consulta, 200);
    }

    public function consultaDeReportes(Request $request){

        $from = $request->input('from2');
        $to = $request->input('to2');
        // dd($request);
        $to1 = $to.' '.'23:59:59';


        $consultaWeb = AppTicket::where('origen', "=", "web")
            ->where("type", "=", "Reporte")
            ->whereBetween("created_at", [$from, $to1])->count();

        $consultaApp = AppTicket::where('origen', "=", "app")
            ->where("type", "=", "Reporte")
            ->whereBetween("created_at", [$from, $to1])->count();

        $consulta = $consultaApp.','.$consultaWeb;

        // dd($consulta);
        return response()->json($consulta, 200);
    }

    public function consultaDeDenuncias(Request $request){

        $from = $request->input('from3');
        $to = $request->input('to3');
        // dd($request);
        $to1 = $to.' '.'23:59:59';

        $consultaWeb = AppTicket::where('origen', "=", "web")
            ->where("type", "=", "Denuncia")
            ->whereBetween("created_at", [$from, $to1])->count();

        $consultaApp = AppTicket::where('origen', "=", "app")
            ->where("type", "=", "Denuncia")
            ->whereBetween("created_at", [$from, $to1])->count();

        $consulta = $consultaApp.','.$consultaWeb;

        // dd($consulta);
        return response()->json($consulta, 200);
    }
}

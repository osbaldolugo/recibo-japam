<?php

namespace App\Http\Controllers;

use App\Models\AppTicket;
use App\Models\Priority;
use App\Models\Sector;
use App\Models\Suburb;
use App\Models\Ticket;
use App\Models\TicketitsApp;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MappingController extends BaseController
{

    public function index()
    {
        return view('mapping.index')
            ->with("sector", Sector::orderBy('name')->pluck("name","id"));
    }

    public function index_app()
    {
        return view('mapping.index_app')
            ->with("sector", Sector::pluck("id","name"));
    }

    /*
    * Post Store Mapping web
    */
    public function store(Request $request){
        $suburb = $request->input("suburb");
        $sector = $request->input("sector");
        $ticket = $request->input("ticket");
        dd(json_encode($request->all()));


        return response()->json([
            'success' => 1,
            'data' => $sector,
            'msg' => 'Mapeo Guardado Correctamente']);
    }


    /*
    * Get routes in web
    */
    public function getRoutes($type){

        $routes = Ruta::select('ruta.id_ruta', 'ruta.numero', 'ruta.alias', 'ruta.lugar', 'ruta.agrupacion', 'ruta.kml', 'ruta_recorrido.origen', 'ruta_recorrido.destino')
            ->join('ruta_recorrido', 'ruta.id_ruta', '=', 'ruta_recorrido.id_ruta')
            ->where('ruta_recorrido.tipo', 'salida')
            ->where('ruta.agrupacion', $type)
            ->orderBy('ruta.numero', 'asc')
            ->get();
        //dd($routes);
        return response()->json([
            'success' => 1,
            'data' => $routes,
            'msg' => 'Rutas <b style="text-transform:uppercase;">'.$type.'s</b> cargadas exitosamente.']);
    }
    /*
     * Get stops in map
     */
    public function getStops($id){
        /*$stops = Ruta::with("rutaUbicacion.ubicacion")
                ->find($id);*/

        $stops = RutaUbicacion::join('ubicacion', 'ruta_ubicacion.id_ubicacion', '=', 'ubicacion.id_ubicacion')
            ->join('ruta', 'ruta_ubicacion.id_ruta', '=', 'ruta.id_ruta')
            ->select('ubicacion.*', 'ruta_ubicacion.*', 'ruta.id_ruta')
            ->where('ruta_ubicacion.id_ruta', $id)
            ->get();

        return response()->json([
            'success' => 1,
            'data' => $stops,
            'msg' => 'Paradas cargadas exitosamente.']);
    }

    /*
     * We obtain the locations of the Tickets
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPlacesTicket(Request $request){
        $status = $request->input('status_ticket');
        $sector = $request->input('sector');
        $suburb = $request->input('suburb');

        $tickets = Ticket::with('incident')->with('suburb')->when($status, function ($query) use ($status){
                return $query->where('status', $status);
            })->when($sector, function ($query) use($sector, $suburb) {
                return $query->whereIn('suburb_id', \DB::table('suburbs')->select('id')->where('sector_id', $sector))->when($suburb, function ($q) use($suburb) {
                    return $q->where('suburb_id', $suburb);
                });
            })->get();
        return response()->json($tickets, 200);
    }

    public function getSuburbs($sector_id) {
        if ($sector_id != 0) {
            $suburbs = Suburb::where('sector_id', $sector_id)->orderBy('suburb')->get();
            return response()->json($suburbs, 200);
        } else {
            return response()->json([], 200);
        }
    }

    /*
     * @return string
     */
    public function getPlacesTicketApp(Request $request){

        $appTicket = AppTicket::select("latitude","longitude","id")->get();

        return response()->json([
            'success' => 1,
            'listTickets' => $appTicket,
            'msg' => ''
        ]);

    }
    
    /*
     * @return string
     */
    public function getPlaces(Request $request){
        $destinoLat = $request->input('latDestiny');
        $destinoLng = $request->input('lngDestiny');
        $meLat = $request->input('meLat');
        $meLng = $request->input('meLng');

        $listRoutesAround = $this->searchRutas($destinoLat, $destinoLng);
        $listRoutesAroundOrder = array();
        foreach ($listRoutesAround as $key => $ruta){
            $isAround = is_null($meLat) ? 0 : count($this->searchRutas($meLat, $meLng, $ruta->id_ruta));
            array_push($listRoutesAroundOrder, [
                'id_ruta'=>$ruta->id_ruta,
                'numero'=>$ruta->numero,
                'alias'=>$ruta->alias,
                'agrupacion'=>$ruta->agrupacion,
                'origen'=>$ruta->origen,
                'destino'=>$ruta->destino,
                'kml'=>$ruta->kml,
                'around' => $isAround
            ]);
            $aux[$key] = $isAround;
        }
        if (count($listRoutesAround) > 0){
            array_multisort($aux, SORT_DESC, $listRoutesAroundOrder);
        }

        return response()->json([
            'success' => 1,
            'listRoutesAround' => $listRoutesAroundOrder,
            'countRoutesAround' => count($listRoutesAround),
            'msg' => '<b class="label label-inverse">#'.count($listRoutesAroundOrder).'</b> Rutas encontradas, clic en el botón <b>RUTAS CERCANAS A TU DESTINO</b> para verlas.'
        ]);
        /*
        DB::statement("SET sql_mode = ''");
        $sql = 'SELECT q.* FROM ';
        $sql .= '(SELECT r.id_ruta, r.numero, r.alias, r.lugar, r.agrupacion, r.kml, rr.origen, rr.destino, ';
        $sql .= '(6371 * ACOS(SIN(RADIANS(lat)) * SIN(RADIANS('.$lat.')) + COS(RADIANS(lng - '.$lng.')) * COS(RADIANS(lat)) * COS(RADIANS('.$lat.')))) AS distance ';
        $sql .= 'FROM  ruta r ';
        $sql .= 'INNER JOIN ruta_trayecto rt ON rt.id_ruta = r.id_ruta ';
        $sql .= 'INNER JOIN ruta_recorrido rr ON rr.id_ruta = r.id_ruta ';
        $sql .= 'WHERE rr.tipo = "salida" ';
        $sql .= 'HAVING distance < .250 ';//250m
        $sql .= 'ORDER BY distance ASC) as q ';
        $sql .= 'GROUP BY numero';

        $listRoutesAround = DB::select( DB::raw($sql));

        //dd($listRoutesAround);
        //return $this->response->array(['listRutasAround'=>$listRoutesAround, 'cantidad' => count($listRoutesAround)]);
        return response()->json([
            'success' => 1,
            'listRoutesAround' => $listRoutesAround,
            'countRoutesAround' => count($listRoutesAround),
            'msg' => '<b class="label label-inverse">#'.count($listRoutesAround).'</b> Rutas encontradas, clic en el botón <b>RUTAS CERCANAS A TU DESTINO</b> para verlas.']);
        */
    }
    /*
     * search routes
     */
    public function searchRutas($lat, $lng, $idRuta = null){
        $listCoordenadas = $this->getBoundaries($lat, $lng);
        
        

        DB::statement("SET sql_mode = ''");
        $sql = 'SELECT q.* FROM ';
        $sql .= '(SELECT r.id_ruta, r.numero, r.alias, r.lugar, r.agrupacion, r.kml, rr.origen, rr.destino, ';
        $sql .= '(6371 * ACOS(SIN(RADIANS(lat)) * SIN(RADIANS('.$lat.')) + COS(RADIANS(lng - '.$lng.')) * COS(RADIANS(lat)) * COS(RADIANS('.$lat.')))) AS distance ';
        $sql .= 'FROM  ruta r ';
        $sql .= 'INNER JOIN ruta_recorrido rr ON rr.id_ruta = r.id_ruta ';
        $sql .= 'INNER JOIN ruta_trayecto rt ON rt.id_ruta = r.id_ruta ';
        $sql .= 'WHERE rr.tipo = "salida" ';
        $sql .= 'AND (lat BETWEEN ' . $listCoordenadas['min_lat']. ' AND ' . $listCoordenadas['max_lat'] . ') ';
        $sql .= 'AND (lng BETWEEN ' . $listCoordenadas['min_lng']. ' AND ' . $listCoordenadas['max_lng']. ') ';
        if(!is_null($idRuta)){
            $sql .= 'AND rt.id_ruta ='.$idRuta.' ';
        }
        $sql .= 'HAVING distance < .250 ';
        $sql .= 'ORDER BY distance ASC) as q ';
        $sql .= 'GROUP BY numero';

        $listRoutesAround = DB::select(DB::raw($sql));
        return $listRoutesAround;
    }
    /*
     * search stops 
     */
    public function nearbyStops(Request $request){
        $idRuta = $request->input('route');
        $meLat = $request->input('meLat');
        $meLng = $request->input('meLng');
        $destinoLat = $request->input('lat');
        $destinoLng = $request->input('lng');
        /*$meLat = (!empty($request->input('meLat'))) ? $request->input('meLat') : 0;
        $meLng = (!empty($request->input('meLng'))) ? $request->input('meLng') : 0;
        $destinoLat = (!empty($request->input('lat'))) ? $request->input('lat') : 0;
        $destinoLng = (!empty($request->input('lng'))) ? $request->input('lng') : 0;*/

        //dd($idRuta.'__'.$meLat.'__'.$meLng.'__'.$destinoLat.'__'.$destinoLng);

        $listStopsDestiny = $this->searchStops($destinoLat, $destinoLng, $idRuta);
        $listStopsDestiny->destinoLat = $destinoLat;
        $listStopsDestiny->destinoLng = $destinoLng;

        $listStopsMe = $this->searchStops($meLat, $meLng, $idRuta);
        $listStopsMe->meLat = $meLat;
        $listStopsMe->meLng = $meLng;
        /*dd([
            "listStopsDestiny"=>$listStopsDestiny,
            "listStopsMe"=>$listStopsMe,
        ]);*/
        return response()->json([
            'success' => 1,
            'listStopsDestiny' => $listStopsDestiny,
            'listStopsMe' => $listStopsMe,
            'msg' => 'Stops found.'
        ]);
    }

    public function searchStops($lat, $lng, $idRuta){
        $listCoordenadas = $this->getBoundariesStops($lat, $lng);
        DB::statement("SET sql_mode = ''");
        $sql = 'SELECT q.* FROM ';
        $sql .= '(SELECT u.id_ubicacion, u.lat, u.lng, u.description, u.type_recorrido, ru.id_ruta_ubicacion, ru.id_ruta, ';
        $sql .= '(6371 * ACOS(SIN(RADIANS(lat)) * SIN(RADIANS('.$lat.')) + COS(RADIANS(lng - '.$lng.')) * COS(RADIANS(lat)) * COS(RADIANS('.$lat.')))) AS distance ';
        $sql .= 'FROM  ubicacion u ';
        $sql .= 'INNER JOIN ruta_ubicacion ru ON ru.id_ubicacion = u.id_ubicacion ';
        $sql .= 'WHERE ru.id_ruta = '.$idRuta.' ';
        //$sql .= 'AND (lat BETWEEN ' . $listCoordenadas['min_lat']. ' AND ' . $listCoordenadas['max_lat'] . ') ';
        //$sql .= 'AND (lng BETWEEN ' . $listCoordenadas['min_lng']. ' AND ' . $listCoordenadas['max_lng']. ') ';
        $sql .= 'HAVING distance < 5 ';
        $sql .= 'ORDER BY distance ASC LIMIT 1) as q ';
        //$sql .= 'GROUP BY numero';

        $listStopsAround = DB::select(DB::raw($sql));

        return $listStopsAround[0];
    }
    /*
     *  Funcion que delimitar un área antes de empezar con el calculo de distancias.
     */
    function getBoundaries($lat, $lng, $distance = .250)
    {
        $earthRadius = 6371;
        $return = array();

        // Los angulos para cada dirección
        $cardinalCoords = array('north' => 0, 'south' => 180, 'east' => 90, 'west' => 270);
        $rLat = deg2rad($lat);
        $rLng = deg2rad($lng);
        $rAngDist = $distance/$earthRadius;
        foreach ($cardinalCoords as $name => $angle){
            $rAngle = deg2rad($angle);
            $rLatB = asin(sin($rLat) * cos($rAngDist) + cos($rLat) * sin($rAngDist) * cos($rAngle));
            $rLonB = $rLng + atan2(sin($rAngle) * sin($rAngDist) * cos($rLat), cos($rAngDist) - sin($rLat) * sin($rLatB));
            $return[$name] = array('lat' => (float) rad2deg($rLatB), 'lng' => (float) rad2deg($rLonB));
        }

        return ['min_lat'  => $return['south']['lat'], 'max_lat' => $return['north']['lat'], 'min_lng' => $return['west']['lng'], 'max_lng' => $return['east']['lng']];
    }
    /*
     * get boundaries with distance = 1 km
     */
    function getBoundariesStops($lat, $lng, $distance = 1)
    {
        $earthRadius = 6371;
        $return = array();

        // Los angulos para cada dirección
        $cardinalCoords = array('north' => 0, 'south' => 180, 'east' => 90, 'west' => 270);
        $rLat = deg2rad($lat);
        $rLng = deg2rad($lng);
        $rAngDist = $distance/$earthRadius;
        foreach ($cardinalCoords as $name => $angle){
            $rAngle = deg2rad($angle);
            $rLatB = asin(sin($rLat) * cos($rAngDist) + cos($rLat) * sin($rAngDist) * cos($rAngle));
            $rLonB = $rLng + atan2(sin($rAngle) * sin($rAngDist) * cos($rLat), cos($rAngDist) - sin($rLat) * sin($rLatB));
            $return[$name] = array('lat' => (float) rad2deg($rLatB), 'lng' => (float) rad2deg($rLonB));
        }

        return ['min_lat'  => $return['south']['lat'], 'max_lat' => $return['north']['lat'], 'min_lng' => $return['west']['lng'], 'max_lng' => $return['east']['lng']];
    }
}

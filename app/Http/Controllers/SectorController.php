<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 10/01/2018
 * Time: 12:59 PM
 */

namespace App\Http\Controllers;

use App\DataTables\SectorDataTable;
use App\DataTables\SuburbDataTable;
use App\DataTables\SuburbSectorDataTable;
use App\Http\Requests\CreateSectorRequest;
use App\Http\Requests\CreateSuburbRequest;
use App\Http\Requests\UpdateSectorRequest;
use App\Models\AppTicket;
use App\Models\Sector;
use App\Models\SectorDots;
use App\Repositories\SectorDotsRepository;
use App\Repositories\SectorRepository;
use App\Repositories\SuburbRepository;
use Flash;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Log;
use Response;

class SectorController extends AppBaseController
{
    /** @var  SectorRepository */
    private $sectorRepository;
    private $suburbRepository;
    private $sectorDotsRepository;

    public function __construct(SectorRepository $sectorRepo, SectorDotsRepository $sectorDotsRepo, SuburbRepository $suburbRepository)
    {
        $this->sectorRepository = $sectorRepo;
        $this->sectorDotsRepository = $sectorDotsRepo;
        $this->suburbRepository = $suburbRepository;
    }

    /**
     * Display a listing of the Sectors.
     *
     * @param SectorDataTable $sectorDataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(SectorDataTable $sectorDataTable)
    {
        return $sectorDataTable->render('sector.index');
    }

    /**
     * Show the form for creating a new Sector.
     *
     * @param SuburbDataTable $suburbDataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function create(SuburbDataTable $suburbDataTable)
    {
        $example = true;
        $sectors = ['-1' => 'Buscar Sector'];
        return $suburbDataTable->render('sector.create', compact('example', 'sectors'));
    }

    /**
     * Store a newly created Sector in storage.
     *
     * @param CreateSectorRequest $request
     *
     * @return Response
     */
    public function store(CreateSectorRequest $request)
    {
        $sector = $request->input("sector");
        $sectorDots = $request->input("sectorDots");

        $sectorCreate = $this->sectorRepository->create($sector);

        for($d = 0; $d < count($sectorDots["lat"]); $d++){

            $dot["sector_id"] = $sectorCreate->id;
            $dot["lat"] = $sectorDots["lat"][$d];
            $dot["lng"] = $sectorDots["lng"][$d];
            $sectorDotsCreate = $this->sectorDotsRepository->create($dot);

        }

        Flash::success('Sector guardado Correctamente.');

        return response()->json(array(
            "success" => 1,
            "msg" => "Sector creado correctamente",
            "data" => $sectorCreate
        ));
    }


    /**
     * Store a new Suburb into Sector
     *
     * @param CreateSectorRequest $request
     *
     * @return Response
     */
    public function addSuburb(CreateSuburbRequest $request)
    {
        $suburb = $request->input("suburb");

        $suburbCreate = $this->suburbRepository->create($suburb);



        Flash::success('Colonia guardada Correctamente.');

        return response()->json(array(
            "success" => 1,
            "msg" => "Colonia creada correctamente",
            "data" => $suburbCreate
        ));
    }

    /**
     * Display the specified Sector.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $incidents = $this->sectorRepository->findWithoutFail($id);

        if (empty($incidents)) {
            Flash::error('Sector not found');

            return redirect(route('sector.index'));
        }

        return view('sector.show')->with('sector', $incidents);
    }

    /**
     * Show the form for editing the specified Sector.
     *
     * @param  int $id
     * @param SuburbDataTable $suburbDataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($id, SuburbDataTable $suburbDataTable)
    {
        $sector = $this->sectorRepository->findWithoutFail($id);
        $sectorDots = $sector->sectorDots;
        if (empty($sector)) {
            Flash::error('Sector not found');
            return redirect(route('sector.index'));
        }
        $sectors = Sector::where('id', $id)->pluck('name', 'id');
        $suburbDataTable->completedTickets($id);
        return $suburbDataTable->render('sector.edit', compact('sector','sectorDots', 'sectors'));
    }

    /**
     * Update the specified Sector in storage.
     *
     * @param  int              $id
     * @param UpdateSectorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSectorRequest $request)
    {
        $sector = $request->input("sector");
        $sectorDots = $request->input("sectorDots");

        $sectorUpdate = $this->sectorRepository->update($sector,$id);

        SectorDots::where("sector_id","=",$sectorUpdate->id)->delete();
        for($d = 0; $d < count($sectorDots["lat"]); $d++){


            $dot["sector_id"] = $sectorUpdate->id;
            $dot["lat"] = $sectorDots["lat"][$d];
            $dot["lng"] = $sectorDots["lng"][$d];
            $sectorDotsCreate = $this->sectorDotsRepository->create($dot);

        }

        Flash::success('Sector Actualizado Correctamente.');

        return response()->json(array(
            "success" => 1,
            "msg" => "Sector actualizado correctamente",
            "data" => $sectorUpdate
        ));
    }

    /**
     * Remove the specified Sector from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $sector = $this->sectorRepository->findWithoutFail($id);
        if (empty($sector)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Sector que se desea eliminar']], 422);
        }
        try {
            $name = $sector->name;
            $this->sectorRepository->delete($id);
            return response()->json(['content' => 'Se ha eliminado el Sector con éxito', 'title' => $name], 200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }


    public function getPlacesTicket(Request $request){

        $appTicket = AppTicket::select("lat","lng","id")->all();
        $ticketitApp = $appTicket->ticketitsApps->appTicket;
        dd($ticketitApp);

        dd($request->all());
    }



    public function getDots(Request $request){

        $sector = $request->input("sector");
        $sectorDots = Sector::find($sector)->sectorDots;
        $sectorSuburbs = Sector::find($sector)->suburb;

        return response()->json(array(
            "success" => 1,
            "msg" => "Puntos del sector". $sector,
            "data" => $sectorDots,
            "suburbs" => $sectorSuburbs
        ));
    }
}
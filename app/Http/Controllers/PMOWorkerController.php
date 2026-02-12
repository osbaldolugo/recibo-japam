<?php

namespace App\Http\Controllers;

use App\DataTables\PMOWorkerDataTable;
use App\Http\Requests\CreatePMOWorkerRequest;
use App\Http\Requests\UpdatePMOWorkerRequest;
use App\Models\PMOSpeciality;
use App\Repositories\PMOWorkerRepository;
use Flash;
use Illuminate\Database\QueryException;
use Log;
use Response;

class PMOWorkerController extends AppBaseController
{
    /** @var  PMOWorkerRepository */
    private $pMOWorkerRepository;

    public function __construct(PMOWorkerRepository $pMOWorkerRepo)
    {
        $this->pMOWorkerRepository = $pMOWorkerRepo;
    }

    /**
     * Display a listing of the PMOWorker.
     *
     * @param PMOWorkerDataTable $pMOWorkerDataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(PMOWorkerDataTable $pMOWorkerDataTable)
    {
        $specialities = PMOSpeciality::all()->pluck("speciality", "id");
        \View::share(['specialities' => $specialities]);
        return $pMOWorkerDataTable->render('p_m_o_workers.index');
    }

    /**
     * Show the form for creating a new PMOWorker.
     *
     * @return Response
     */
    public function create()
    {
        Flash::error('La vista que intenta mostrar no existe');
        return redirect(route('pMOWorkers.index'));
    }

    /**
     * Store a newly created PMOWorker in storage.
     *
     * @param CreatePMOWorkerRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreatePMOWorkerRequest $request)
    {
        try {
            $input = $request->all();
            $this->pMOWorkerRepository->create($input);
            return response()->json(['content' => 'Se ha agregado un Nuevo Trabajador al catálogo', 'title' => 'Nuevo Trabajador'], 200);
        } catch (QueryException $e) {
            Log::error('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }

    /**
     * Display the specified PMOWorker.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        Flash::error('La vista que intenta mostrar no existe');
        return redirect(route('pMOWorkers.index'));
    }

    /**
     * Show the form for editing the specified PMOWorker.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $pMOWorker = $this->pMOWorkerRepository->findWithoutFail($id);
        if (empty($pMOWorker)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Trabajador que se desea actualizar']], 422);
        }
        return response()->json(array("pMOWorker" => $pMOWorker), 200);
    }

    /**
     * Update the specified PMOWorker in storage.
     *
     * @param  int $id
     * @param UpdatePMOWorkerRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdatePMOWorkerRequest $request)
    {
        $pMOWorker = $this->pMOWorkerRepository->findWithoutFail($id);
        if (empty($pMOWorker)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Trabajador que se desea actualizar']], 422);
        }
        try {
            $this->pMOWorkerRepository->update($request->all(), $id);
            return response()->json(['content' => 'Se ha actualizado la información del Trabajador', 'title' => 'Actualización'], 200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }

    /**
     * Remove the specified PMOWorker from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $pMOWorker = $this->pMOWorkerRepository->findWithoutFail($id);
        if (empty($pMOWorker)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Trabajador que se desea eliminar']], 422);
        }
        try {
            $name = $pMOWorker->name;
            $this->pMOWorkerRepository->delete($id);
            return response()->json(['content' => 'Se ha eliminado al Trabajador con éxito', 'title' => $name],200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }
}

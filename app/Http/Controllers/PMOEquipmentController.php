<?php

namespace App\Http\Controllers;

use App\DataTables\PMOEquipmentDataTable;
use App\Http\Requests\CreatePMOEquipmentRequest;
use App\Http\Requests\UpdatePMOEquipmentRequest;
use App\Repositories\PMOEquipmentRepository;
use Flash;
use Illuminate\Database\QueryException;
use Log;
use Response;

class PMOEquipmentController extends AppBaseController
{
    /** @var  PMOEquipmentRepository */
    private $pMOEquipmentRepository;

    public function __construct(PMOEquipmentRepository $pMOEquipmentRepo)
    {
        $this->pMOEquipmentRepository = $pMOEquipmentRepo;
    }

    /**
     * Display a listing of the PMOEquipment.
     *
     * @param PMOEquipmentDataTable $pMOEquipmentDataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(PMOEquipmentDataTable $pMOEquipmentDataTable)
    {
        return $pMOEquipmentDataTable->render('p_m_o_equipments.index');
    }

    /**
     * Show the form for creating a new PMOEquipment.
     *
     * @return Response
     */
    public function create()
    {
        Flash::error('La vista que intenta mostrar no existe');
        return redirect(route('pMOEquipments.index'));
    }

    /**
     * Store a newly created PMOEquipment in storage.
     *
     * @param CreatePMOEquipmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreatePMOEquipmentRequest $request)
    {
        try {
            $input = $request->all();
            $this->pMOEquipmentRepository->create($input);
            return response()->json(['content' => 'Se ha agregado un Nuevo Equipo al catálogo', 'title' => 'Nuevo Equipo'], 200);
        } catch (QueryException $e) {
            Log::error('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }

    /**
     * Display the specified PMOEquipment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        Flash::error('La vista que intenta mostrar no existe');
        return redirect(route('pMOEquipments.index'));
    }

    /**
     * Show the form for editing the specified PMOEquipment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pMOEquipment = $this->pMOEquipmentRepository->findWithoutFail($id);
        if (empty($pMOEquipment)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Equipo que se desea actualizar']], 422);
        }
        return response()->json(array("pMOEquipment" => $pMOEquipment), 200);
    }

    /**
     * Update the specified PMOEquipment in storage.
     *
     * @param  int $id
     * @param UpdatePMOEquipmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdatePMOEquipmentRequest $request)
    {
        $pMOEquipment = $this->pMOEquipmentRepository->findWithoutFail($id);
        if (empty($pMOEquipment)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Equipo que se desea actualizar']], 422);
        }
        try {
            $this->pMOEquipmentRepository->update($request->all(), $id);
            return response()->json(['content' => 'Se ha actualizado el Equipo', 'title' => 'Actualización'], 200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }

    /**
     * Remove the specified PMOEquipment from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $pMOEquipment = $this->pMOEquipmentRepository->findWithoutFail($id);
        if (empty($pMOEquipment)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Equipo que se desea eliminar']], 422);
        }
        try {
            $code = $pMOEquipment->code;
            $this->pMOEquipmentRepository->delete($id);
            return response()->json(['content' => 'Se ha eliminado el Equipo con éxito', 'title' => $code],200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }
}

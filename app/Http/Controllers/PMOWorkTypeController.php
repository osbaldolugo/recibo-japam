<?php

namespace App\Http\Controllers;

use App\DataTables\PMOWorkTypeDataTable;
use App\Http\Requests\CreatePMOWorkTypeRequest;
use App\Http\Requests\UpdatePMOWorkTypeRequest;
use App\Repositories\PMOWorkTypeRepository;
use Flash;
use Illuminate\Database\QueryException;
use Log;
use Response;

class PMOWorkTypeController extends AppBaseController
{
    /** @var  PMOWorkTypeRepository */
    private $pMOWorkTypeRepository;

    public function __construct(PMOWorkTypeRepository $pMOWorkTypeRepo)
    {
        $this->pMOWorkTypeRepository = $pMOWorkTypeRepo;
    }

    /**
     * Display a listing of the PMOWorkType.
     *
     * @param PMOWorkTypeDataTable $pMOWorkTypeDataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(PMOWorkTypeDataTable $pMOWorkTypeDataTable)
    {
        return $pMOWorkTypeDataTable->render('p_m_o_work_types.index');
    }

    /**
     * Show the form for creating a new PMOWorkType.
     *
     * @return Response
     */
    public function create()
    {
        Flash::error('La vista que intenta mostrar no existe');
        return redirect(route('p_m_o_work_types.index'));
    }

    /**
     * Store a newly created PMOWorkType in storage.
     *
     * @param CreatePMOWorkTypeRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreatePMOWorkTypeRequest $request)
    {
        try {
            $input = $request->all();
            $this->pMOWorkTypeRepository->create($input);
            return response()->json(['content' => 'Se ha agregado un Nuevo Tipo de Trabajo al catálogo', 'title' => 'Nuevo Tipo de Trabajo'], 200);
        } catch (QueryException $e) {
            Log::error('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }

    /**
     * Display the specified PMOWorkType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        Flash::error('La vista que intenta mostrar no existe');
        return redirect(route('p_m_o_work_types.index'));
    }

    /**
     * Show the form for editing the specified PMOWorkType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pMOWorkType = $this->pMOWorkTypeRepository->findWithoutFail($id);
        if (empty($pMOWorkType)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Tipo de Trabajo que se desea actualizar']], 422);
        }
        return response()->json(array("workType" => $pMOWorkType), 200);
    }

    /**
     * Update the specified PMOWorkType in storage.
     *
     * @param  int $id
     * @param UpdatePMOWorkTypeRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdatePMOWorkTypeRequest $request)
    {
        $pMOWorkType = $this->pMOWorkTypeRepository->findWithoutFail($id);
        if (empty($pMOWorkType)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Tipo de Trabajo que se desea actualizar']], 422);
        }
        try {
            $this->pMOWorkTypeRepository->update($request->all(), $id);
            return response()->json(['content' => 'Se ha actualizado el Tipo de Trabajo', 'title' => 'Actualización'], 200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }

    /**
     * Remove the specified PMOWorkType from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $pMOWorkType = $this->pMOWorkTypeRepository->findWithoutFail($id);
        if (empty($pMOWorkType)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Tipo de Trabajo que se desea eliminar']], 422);
        }
        try {
            $code = $pMOWorkType->code;
            $this->pMOWorkTypeRepository->delete($id);
            return response()->json(['content' => 'Se ha eliminado el Tipo de Trabajo con éxito', 'title' => $code],200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }
}

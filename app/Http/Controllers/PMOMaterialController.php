<?php

namespace App\Http\Controllers;

use App\DataTables\PMOMaterialDataTable;
use App\Http\Requests\CreatePMOMaterialRequest;
use App\Http\Requests\UpdatePMOMaterialRequest;
use App\Repositories\PMOMaterialRepository;
use Flash;
use Illuminate\Database\QueryException;
use Log;
use Response;

class PMOMaterialController extends AppBaseController
{
    /** @var  PMOMaterialRepository */
    private $pMOMaterialRepository;

    public function __construct(PMOMaterialRepository $pMOMaterialRepo)
    {
        $this->pMOMaterialRepository = $pMOMaterialRepo;
    }

    /**
     * Display a listing of the PMOMaterial.
     *
     * @param PMOMaterialDataTable $pMOMaterialDataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(PMOMaterialDataTable $pMOMaterialDataTable)
    {
        return $pMOMaterialDataTable->render('p_m_o_materials.index');
    }

    /**
     * Show the form for creating a new PMOMaterial.
     *
     * @return Response
     */
    public function create()
    {
        Flash::error('La vista que intenta mostrar no existe');
        return redirect(route('pMOMaterials.index'));
    }

    /**
     * Store a newly created PMOMaterial in storage.
     *
     * @param CreatePMOMaterialRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreatePMOMaterialRequest $request)
    {
        try {
            $input = $request->all();
            $this->pMOMaterialRepository->create($input);
            return response()->json(['content' => 'Se ha agregado un Nuevo Material al catálogo', 'title' => 'Nuevo Material'], 200);
        } catch (QueryException $e) {
            Log::error('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }

    /**
     * Display the specified PMOMaterial.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        Flash::error('La vista que intenta mostrar no existe');
        return redirect(route('pMOMaterials.index'));
    }

    /**
     * Show the form for editing the specified PMOMaterial.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pMOMaterial = $this->pMOMaterialRepository->findWithoutFail($id);
        if (empty($pMOMaterial)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Material que se desea actualizar']], 422);
        }
        return response()->json(array("pMOMaterial" => $pMOMaterial), 200);
    }

    /**
     * Update the specified PMOMaterial in storage.
     *
     * @param  int $id
     * @param UpdatePMOMaterialRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdatePMOMaterialRequest $request)
    {
        $pMOMaterial = $this->pMOMaterialRepository->findWithoutFail($id);
        if (empty($pMOMaterial)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Material que se desea actualizar']], 422);
        }
        try {
            $this->pMOMaterialRepository->update($request->all(), $id);
            return response()->json(['content' => 'Se ha actualizado el Material', 'title' => 'Actualización'], 200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }

    /**
     * Remove the specified PMOMaterial from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $pMOMaterial = $this->pMOMaterialRepository->findWithoutFail($id);
        if (empty($pMOMaterial)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Material que se desea eliminar']], 422);
        }
        try {
            $code = $pMOMaterial->code;
            $this->pMOMaterialRepository->delete($id);
            return response()->json(['content' => 'Se ha eliminado el Material con éxito', 'title' => $code],200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }
}

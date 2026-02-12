<?php

namespace App\Http\Controllers;

use App\DataTables\PMOWorkDataTable;
use App\Http\Requests\CreatePMOWorkRequest;
use App\Http\Requests\UpdatePMOWorkRequest;
use App\Repositories\PMOWorkRepository;
use Flash;
use Illuminate\Database\QueryException;
use Log;
use Response;

class PMOWorkController extends AppBaseController
{
    /** @var  PMOWorkRepository */
    private $pMOWorkRepository;

    public function __construct(PMOWorkRepository $pMOWorkRepo)
    {
        $this->pMOWorkRepository = $pMOWorkRepo;
    }

    /**
     * Display a listing of the PMOWork.
     *
     * @param PMOWorkDataTable $pMOWorkDataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(PMOWorkDataTable $pMOWorkDataTable)
    {
        return $pMOWorkDataTable->render('p_m_o_works.index');
    }

    /**
     * Show the form for creating a new PMOWork.
     *
     * @return Response
     */
    public function create()
    {
        Flash::error('La vista que intenta mostrar no existe');
        return redirect(route('pMOWorks.index'));
    }

    /**
     * Store a newly created PMOWork in storage.
     *
     * @param CreatePMOWorkRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreatePMOWorkRequest $request)
    {
        try {
            $input = $request->all();
            $this->pMOWorkRepository->create($input);
            return response()->json(['content' => 'Se ha agregado un Nuevo Trabajo al catálogo', 'title' => 'Nuevo Trabajo'], 200);
        } catch (QueryException $e) {
            Log::error('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }

    /**
     * Display the specified PMOWork.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        Flash::error('La vista que intenta mostrar no existe');
        return redirect(route('pMOWorks.index'));
    }

    /**
     * Show the form for editing the specified PMOWork.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $pMOWork = $this->pMOWorkRepository->findWithoutFail($id);
        if (empty($pMOWork)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Trabajo que se desea actualizar']], 422);
        }
        return response()->json(array("work" => $pMOWork), 200);
    }

    /**
     * Update the specified PMOWork in storage.
     *
     * @param int $id
     * @param UpdatePMOWorkRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdatePMOWorkRequest $request)
    {
        $pMOWork = $this->pMOWorkRepository->findWithoutFail($id);
        if (empty($pMOWork)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Trabajo que se desea actualizar']], 422);
        }
        try {
            $this->pMOWorkRepository->update($request->all(), $id);
            return response()->json(['content' => 'Se ha actualizado el Trabajo', 'title' => 'Actualización'], 200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }

    /**
     * Remove the specified PMOWork from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $pMOWork = $this->pMOWorkRepository->findWithoutFail($id);
        if (empty($pMOWork)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Trabajo que se desea eliminar']], 422);
        }
        try {
            $code = $pMOWork->code;
            $this->pMOWorkRepository->delete($id);
            return response()->json(['content' => 'Se ha eliminado el Trabajo con éxito', 'title' => $code],200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }
}

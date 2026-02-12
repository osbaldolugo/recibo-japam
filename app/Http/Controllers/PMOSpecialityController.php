<?php

namespace App\Http\Controllers;

use App\DataTables\PMOSpecialityDataTable;
use App\Http\Requests\CreatePMOSpecialityRequest;
use App\Http\Requests\UpdatePMOSpecialityRequest;
use App\Repositories\PMOSpecialityRepository;
use Flash;
use Illuminate\Database\QueryException;
use Log;
use Response;

class PMOSpecialityController extends AppBaseController
{
    /** @var  PMOSpecialityRepository */
    private $pMOSpecialityRepository;

    public function __construct(PMOSpecialityRepository $pMOSpecialityRepo)
    {
        $this->pMOSpecialityRepository = $pMOSpecialityRepo;
    }

    /**
     * Display a listing of the PMOSpeciality.
     *
     * @param PMOSpecialityDataTable $pMOSpecialityDataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(PMOSpecialityDataTable $pMOSpecialityDataTable)
    {
        return $pMOSpecialityDataTable->render('p_m_o_specialities.index');
    }

    /**
     * Show the form for creating a new PMOSpeciality.
     *
     * @return Response
     */
    public function create()
    {
        Flash::error('La vista que intenta mostrar no existe');
        return redirect(route('pMOSpecialities.index'));
    }

    /**
     * Store a newly created PMOSpeciality in storage.
     *
     * @param CreatePMOSpecialityRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreatePMOSpecialityRequest $request)
    {
        try {
            $input = $request->all();
            $this->pMOSpecialityRepository->create($input);
            return response()->json(['content' => 'Se ha agregado una Nueva Especialidad al catálogo', 'title' => 'Nueva Especialidad'], 200);
        } catch (QueryException $e) {
            Log::error('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }

    /**
     * Display the specified PMOSpeciality.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        Flash::error('La vista que intenta mostrar no existe');
        return redirect(route('pMOSpecialities.index'));
    }

    /**
     * Show the form for editing the specified PMOSpeciality.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $pMOSpeciality = $this->pMOSpecialityRepository->findWithoutFail($id);
        if (empty($pMOSpeciality)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información de la Especialidad que se desea actualizar']], 422);
        }
        return response()->json(array("pMOSpecialty" => $pMOSpeciality), 200);
    }

    /**
     * Update the specified PMOSpeciality in storage.
     *
     * @param  int $id
     * @param UpdatePMOSpecialityRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdatePMOSpecialityRequest $request)
    {
        $pMOSpeciality = $this->pMOSpecialityRepository->findWithoutFail($id);
        if (empty($pMOSpeciality)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información de la Especialidad que se desea actualizar']], 422);
        }
        try {
            $this->pMOSpecialityRepository->update($request->all(), $id);
            return response()->json(['content' => 'Se ha actualizado la Especialidad', 'title' => 'Actualización'], 200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }

    /**
     * Remove the specified PMOSpeciality from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $pMOSpeciality = $this->pMOSpecialityRepository->findWithoutFail($id);
        if (empty($pMOSpeciality)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información de la Especialidad que se desea eliminar']], 422);
        }
        try {
            $speciality = $pMOSpeciality->speciality;
            $this->pMOSpecialityRepository->delete($id);
            return response()->json(['content' => 'Se ha eliminado la Especialidad con éxito', 'title' => $speciality],200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }
}

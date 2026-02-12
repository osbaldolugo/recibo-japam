<?php

namespace App\Http\Controllers;

use App\DataTables\PriorityDataTable;
use App\Http\Requests\CreatePriorityRequest;
use App\Http\Requests\UpdatePriorityRequest;
use App\Models\Priority;
use App\Repositories\PriorityRepository;
use Flash;
use Illuminate\Database\QueryException;
use Log;
use Response;

class PriorityController extends AppBaseController
{
    /** @var  PriorityRepository */
    private $priorityRepository;

    public function __construct(PriorityRepository $priorityRepo)
    {
        $this->priorityRepository = $priorityRepo;
    }

    /**
     * Display a listing of the Priority.
     *
     * @param PriorityDataTable $priorityDataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(PriorityDataTable $priorityDataTable)
    {
        return $priorityDataTable->render('priorities.index');
    }

    /**
     * Show the form for creating a new Priority.
     *
     * @return Response
     */
    public function create()
    {
        return view('priorities.create');
    }

    /**
     * Store a newly created Priority in storage.
     *
     * @param CreatePriorityRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreatePriorityRequest $request)
    {
        try {
            $input = $request->all();
            Priority::create($input);
            return response()->json(['content' => 'Se ha agregado una nueva prioridad al catálogo', 'title' => 'Nueva Prioridad'], 200);
        } catch (QueryException $e) {
            Log::error('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }

    /**
     * Display the specified Priority.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        Flash::error('La vista que intenta mostrar no existe');
        return redirect(route('priorities.index'));
    }

    /**
     * Show the form for editing the specified Priority.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $priority = $this->priorityRepository->findWithoutFail($id);
        if (empty($priority)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información de la prioridad que se desea actualizar']], 422);
        }
        return response()->json(["priority" => $priority], 200);
    }

    /**
     * Update the specified Priority in storage.
     *
     * @param $id
     * @param UpdatePriorityRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdatePriorityRequest $request)
    {
        $priority = $this->priorityRepository->findWithoutFail($id);
        if (empty($priority)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información de la prioridad que se desea actualizar']], 422);
        }
        try {
            $this->priorityRepository->update($request->all(), $id);
            return response()->json(['content' => 'Se ha actualizado la prioridad', 'title' => 'Actualización'], 200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }

    }

    /**
     * Remove the specified Priority from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $priority = $this->priorityRepository->findWithoutFail($id);
        if (empty($priority)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información de la prioridad que se desea eliminar']], 422);
        }
        try {
            $name = $priority->name;
            $this->priorityRepository->delete($id);
            return response()->json(['content' => 'Se ha eliminado la prioridad con éxito', 'title' => $name],200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }
}

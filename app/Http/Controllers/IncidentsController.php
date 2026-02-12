<?php

namespace App\Http\Controllers;

use App\DataTables\IncidentsDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateIncidentsRequest;
use App\Http\Requests\UpdateIncidentsRequest;
use App\Models\Incidents;
use App\Repositories\IncidentsRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Database\QueryException;
use Response;

class IncidentsController extends AppBaseController
{
    /** @var  IncidentsRepository */
    private $incidentsRepository;

    public function __construct(IncidentsRepository $incidentsRepo)
    {
        $this->incidentsRepository = $incidentsRepo;
    }

    /**
     * Display a listing of the Incidents.
     *
     * @param IncidentsDataTable $incidentsDataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(IncidentsDataTable $incidentsDataTable)
    {
        return $incidentsDataTable->render('incidents.index');
    }

    /**
     * Show the form for creating a new Incidents.
     *
     * @return Response
     */
    public function create()
    {
        return view('incidents.create');
    }

    /**
     * Store a newly created Incidents in storage.
     *
     * @param CreateIncidentsRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateIncidentsRequest $request)
    {
        try {
            $input = $request->all();
            Incidents::create([
                'name' => $input['name'],
                'description' => $input['description'],
                'ticket' => isset($input['ticket']) ? 1 : 0,
                'user_required' => isset($input['user_required']) ? 1 : 0,
                'receipt_required' => isset($input['receipt_required']) ? 1 : 0
            ]);
            return response()->json(["title" => "Nuevo Motivo de Llamada", "content" => $input['name']], 200);
        } catch (QueryException $e) {
            \Log::error('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            return response()->json(['errors' => ['Error' => $e->getMessage()]], 422);
        }

    }

    /**
     * Display the specified Incidents.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        Flash::error('La vista que intenta mostrar no existe');
        return redirect(route('incidents.index'));
    }

    /**
     * Show the form for editing the specified Incidents.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $incidents = $this->incidentsRepository->findWithoutFail($id);
        if (empty($incidents)) {
            return response()->json(['errors' => ['Error' => 'No se encontro la información del Motivo de Llamada']], 422);
        }
        return response()->json(array("incidents" => $incidents), 200);
    }

    /**
     * Update the specified Incidents in storage.
     *
     * @param  int              $id
     * @param UpdateIncidentsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateIncidentsRequest $request)
    {
        try {
            $incidents = $this->incidentsRepository->findWithoutFail($id);
            if (empty($incidents)) {
                return response()->json(['errors' => ['Error' => 'No se encontro la información del Motivo de Llamada']], 422);
            }
            $ticket = $request->input('ticket');
            $user_required = $request->input('user_required');
            $receipt_required = $request->input('receipt_required');
            $incidentsRequest = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'ticket' => isset($ticket) ? 1 : 0,
                'user_required' => isset($user_required) ? 1 : 0,
                'receipt_required' => isset($receipt_required) ? 1 : 0
            ];
            Incidents::find($id)->update($incidentsRequest);
            return response()->json(array("content" => $request->input('name'), "title" => "El Motivo de Llamada fue actualizado"), 200);
        } catch (QueryException $e) {
            \Log::error('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            return response()->json(['errors' => ['Error' => $e->getMessage()]], 422);
        }
    }

    /**
     * Remove the specified Incidents from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $incidents = $this->incidentsRepository->findWithoutFail($id);
        if (empty($incidents)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Motivo de Llamada que se desea eliminar']], 422);
        }
        try {
            $name = $incidents->name;
            $this->incidentsRepository->delete($id);
            return response()->json(['content' => 'Se ha eliminado el Motivo de Llamada con éxito', 'title' => $name],200);
        } catch (QueryException $e) {
            \Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }


    /**
     * get Steps required to create Ticket
     *
     * @param  int $id
     *
     * @return Response
     */
    public function getSteps($id)
    {
        $incidents = $this->incidentsRepository->findWithoutFail($id);

        if (empty($incidents)) {
            return response()->json(array("success" => 0, "msg"=>"No se encontró un ID"));
        }

        return response()->json(array("success" => 1, "data"=>$incidents));
    }
}

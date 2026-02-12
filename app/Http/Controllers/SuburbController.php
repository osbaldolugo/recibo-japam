<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 10/01/2018
 * Time: 04:29 PM
 */

namespace App\Http\Controllers;

use App\DataTables\SuburbDataTable;
use App\Http\Requests\CreateSuburbRequest;
use App\Http\Requests\UpdateSuburbRequest;
use App\Models\Sector;
use App\Models\Suburb;
use App\Repositories\SuburbRepository;
use Flash;
use Illuminate\Database\QueryException;
use Log;
use Response;

class SuburbController extends AppBaseController
{
    /** @var  SuburbRepository */
    private $suburbRepository;

    public function __construct(SuburbRepository $suburbRepo)
    {
        $this->suburbRepository = $suburbRepo;
    }

    /**
     * Display a listing of the Sectors.
     *
     * @param SuburbDataTable $suburbDataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(SuburbDataTable $suburbDataTable)
    {
        $sectors = Sector::all()->pluck("name", "id");
        \View::share(['sectors' => $sectors]);
        return $suburbDataTable->render('suburbs.index');
    }

    /**
     * Show the form for creating a new Suburb.
     *
     * @return Response
     */
    public function create()
    {
        Flash::error('La vista que intenta mostrar no existe');
        return redirect(route('suburbs.index'));
    }

    /**
     * Store a newly created Sector in storage.
     *
     * @param CreateSuburbRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateSuburbRequest $request)
    {
        try {
            $input = $request->all();
            $this->suburbRepository->create($input);
            return response()->json(['content' => 'Se ha agregado una Nueva Colonia al catálogo', 'title' => 'Nueva Colonia'], 200);
        } catch (QueryException $e) {
            Log::error('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }

    /**
     * Display the specified Suburb.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        Flash::error('La vista que intenta mostrar no existe');
        return redirect(route('suburbs.index'));
    }

    /**
     * Show the form for editing the specified Suburb.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $suburb = $this->suburbRepository->findWithoutFail($id);
        if (empty($suburb)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información de la Colonia que se desea actualizar']], 422);
        }
        return response()->json(array("suburb" => $suburb), 200);
    }

    /**
     * Update the specified Suburb from storage.
     *
     * @param  int $id
     * @param UpdateSuburbRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdateSuburbRequest $request)
    {
        $suburb = $this->suburbRepository->findWithoutFail($id);
        if (empty($suburb)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información de la Colonia que se desea actualizar']], 422);
        }
        try {
            $this->suburbRepository->update($request->all(), $id);
            return response()->json(['content' => 'Se ha actualizado la Colonia', 'title' => 'Actualización'], 200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }

    }

    /**
     * Remove the specified Suburb from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $suburb = $this->suburbRepository->findWithoutFail($id);
        if (empty($suburb)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información de la Colonia que se desea eliminar']], 422);
        }
        try {
            $name = $suburb->suburb;
            $this->suburbRepository->delete($id);
            return response()->json(['content' => 'Se ha eliminado la Colonia con éxito', 'title' => $name], 200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }
}